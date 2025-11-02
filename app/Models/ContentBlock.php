<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'product_content_id',
        'block_type',
        'block_order',
        'content',
        'media_type',
        'media_path',
        'media_url',
        'caption',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function productContent()
    {
        return $this->belongsTo(ProductContent::class);
    }

    /**
     * Get the full URL for the media file
     */
    public function getMediaUrlAttribute()
    {
        if ($this->attributes['media_url']) {
            return $this->attributes['media_url'];
        }
        
        if ($this->media_path) {
            return asset('storage/' . $this->media_path);
        }
        
        return null;
    }
}
