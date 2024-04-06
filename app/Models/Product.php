<?php

namespace App\Models;

use App\Models\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public static function booted()
    {
        // static::addGlobalScope('store', new ProductScope());
        static::addGlobalScope(ProductScope::class);
    }
}
