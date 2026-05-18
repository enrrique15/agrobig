<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'image',
        'presentation',
        'abreviation',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function latestPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany('effective_date');
    }
}
