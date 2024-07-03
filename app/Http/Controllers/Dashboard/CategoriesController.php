<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        return view('dashboard.categories.index', [
            // SELECT categories.* , parents.name as parent_name FROM categories as a LEFT JOIN categories as parents ON parents.id = categories.parent_id
            'categories' => Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
                ->select([
                    'categories.*',
                    'parents.name as parent_name'
                ])
                // ->selectRaw('(SELECT count(*) FROM products WHERE category_id = categories.id) AS products_count')
                ->withCount('products')
                ->filterBy_name_status(request()->query())
                ->orderBy('categories.name')
                ->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (!Gate::allows('categories.create')) {
        //     abort(403);
        // }

        Gate::authorize('categories.create');
        return view('dashboard.categories.create', ['parents' => Category::all(), 'category' => new Category()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $formData = $request->validated();
        $formData['slug'] = Str::slug($request->post('name'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', ['disk' => 'public']); //request->file('image') uploadedFile Object
            $formData['image'] = $path;
        }
        Category::create($formData);
        return redirect(route('dashboard.categories.index'))->with('success', 'category has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        return view('dashboard.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');

        $category = Category::find($id);
        if (!$category)
            return redirect(route('dashboard.categories.index'))->with('danger', 'no category found');


        // SELECT * FROM categories WHERE id <> $id AND (parent_id IS NULL OR parent_id <> $id)
        $parents = Category::where('id', '<>', $id)
            ->where(function (Builder $query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();

        return view('dashboard.categories.edit', ['category' => $category, 'parents' => $parents]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect(route('dashboard.categories.index'))->with('danger', 'no category found');
        }

        $old_image = $category->image;
        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', ['disk' => 'public']); //request->file('image') uploadedFile Object
            $formData['image'] = $path;
        }

        $category->update($formData);

        if ($old_image && isset($formData['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect(route('dashboard.categories.index'))->with('info', 'category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!Gate::allows('categories.delete')) {
            abort(403);
        }
        $category->delete();
        // Category::destroy($id);
        return redirect(route('dashboard.categories.index'))->with('warning', 'category has been deleted');
    }

    public function trash()
    {
        if (!Gate::allows('categories.delete')) {
            abort(403);
        }
        return view('dashboard.categories.trash', ['categories' => Category::onlyTrashed()->filterBy_name_status(request()->query())->paginate(3)]);
    }

    public function restore(string $id)
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        $category = Category::onlyTrashed()->findOrFail($id);

        if (!$category) {
            return to_route('dashboard.categories.trash')->with('danger', 'category not found');
        }

        $category->restore();
        return redirect(route('dashboard.categories.trash'))->with('success', 'category Restored');
    }

    public function forceDelete(string $id)
    {
        if (!Gate::allows('categories.delete')) {
            abort(403);
        }
        $category = Category::onlyTrashed()->findOrFail($id);
        if (!$category) {
            return to_route('dashboard.categories.trash')->with('danger', 'category not found');
        }

        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return to_route('dashboard.categories.trash')->with('warning', 'category has been permanent deleted');
    }
}
