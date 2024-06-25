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

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
        'image'
    ];

    protected $appends = ['image_url'];

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
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active'
        ], $filters);

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });

        $builder->when($options['tag_id'], function (Builder $builder, $value) {
            $builder->whereExists(function (Builder $query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });

            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);
            // $builder->whereRaw('EXITS IN (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);

            // $builder->whereHas('tags', function (Builder $builder) use ($value) {
            //     $builder->where('id', $value);
            // });
        });
    }
}
