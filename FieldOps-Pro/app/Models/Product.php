<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'image_path',
        'active',
        'content_sections',
    ];

    protected $casts = [
        'content_sections' => 'array',
        'active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function contents()
    {
        return $this->hasMany(ProductContent::class)->orderBy('section_order');
    }
    
    public function publishedContents()
    {
        return $this->hasMany(ProductContent::class)
            ->where('is_published', true)
            ->orderBy('section_order');
    }
}
