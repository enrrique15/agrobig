<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'product_id',
        'effective_date',
        'price',
    ];

    function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $casts = [
        'effective_date' => 'date',
    ];
}
