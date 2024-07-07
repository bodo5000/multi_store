<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        $job = new ImportProducts($request->post('count'));
        ImportProducts::dispatch($job)->onQueue('import')->onConnection('database')->delay(now()->addSeconds(5));

        return view(
            'dashboard.products.index',
            [
                'products' => Product::with(['category', 'store'])->paginate()
            ]
        )->with('success', 'import is running');
    }
}
