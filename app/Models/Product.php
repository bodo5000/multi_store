<?php

namespace App\Models;

use App\Models\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category_id',
        'store_id',
        'price',
        'compare_price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id', 'id', 'id');
    }

    public function scopeGetActive(Builder $builder)
    {
        return $builder->where('status', 'active')->with('category')->latest()->take(8)->get();
    }

    // accessor
    public function getImageUrlAttribute()
    {
        if (!$this->image)
            return 'http://www.sitech.co.id/assets/img/products/default.jpg';

        if (Str::startsWith($this->image, ['http://', 'https://']))
            return $this->image;

        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price)
            return 0;

        return round(100 - (100 * $this->price / $this->compare_price));
    }

    protected static function booted()
    {
        // static::addGlobalScope('store', new ProductScope());
        static::addGlobalScope(ProductScope::class);
    }
}
