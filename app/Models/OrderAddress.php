<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'number',
        'city',
        'country',
        'street_address',
        'postal_code'
    ];

    // accessor
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    //accessor
    public function getCountryNameAttribute()
    {
        return Countries::getName($this->country);
    }
}
