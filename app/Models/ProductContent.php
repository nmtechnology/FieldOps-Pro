<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductContent extends Model
{
    protected $fillable = [
        'product_id',
        'parent_id',
        'title',
        'description',
        'slug',
        'section_type',
        'section_order',
        'duration_minutes',
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

    public function parent()
    {
        return $this->belongsTo(ProductContent::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductContent::class, 'parent_id')->orderBy('section_order');
    }

    public function blocks()
    {
        return $this->hasMany(ContentBlock::class)->orderBy('block_order');
    }

    public function userProgress()
    {
        return $this->hasMany(UserContentProgress::class);
    }

    /**
     * Check if this is a chapter (has no parent)
     */
    public function isChapter()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this is a section (has a parent)
     */
    public function isSection()
    {
        return !is_null($this->parent_id);
    }
}
