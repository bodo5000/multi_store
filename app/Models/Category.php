<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'description', 'image', 'status', 'slug'];

    public function scopeFilterBy_name_status(Builder $query, array $filters)
    {
        $query->when($filters['name'] ?? false, function (Builder $builder, $value) {
            $builder->where('categories.name', 'LIKE', $value);
        });

        $query->when($filters['status'] ?? false, function (Builder $builder, $value) {
            $builder->where('categories.status', 'LIKE', $value);
        });
    }
}
