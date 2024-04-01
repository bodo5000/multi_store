<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.categories.index', ['categories' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create', ['parents' => Category::all()]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category)
            return redirect(route('dashboard.categories.index'))->with('error', 'no category found');


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
            return redirect(route('dashboard.categories.index'))->with('error', 'no category found');
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

        return redirect(route('dashboard.categories.index'))->with('success', 'category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        // Category::destroy($id);
        return redirect(route('dashboard.categories.index'))->with('success', 'category has been deleted');
    }
}
