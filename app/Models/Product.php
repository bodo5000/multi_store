<?php

namespace App\Models;

use App\Models\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function booted()
    {
        // static::addGlobalScope('store', new ProductScope());
        static::addGlobalScope(ProductScope::class);
    }
}
