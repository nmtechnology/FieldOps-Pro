<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductContent extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'slug',
        'section_type',
        'section_order',
        'content',
        'media',
        'downloads',
        'is_premium',
        'is_published',
    ];
    
    protected $casts = [
        'media' => 'array',
        'downloads' => 'array',
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
