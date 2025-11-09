<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'short_description',
        'type',
        'price',
        'image_path',
        'active',
        'content_sections',
    ];

    protected $casts = [
        'content_sections' => 'array',
        'active' => 'boolean',
        'price' => 'decimal:2',
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

    /**
     * Get the product image URL, using default if none set
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            // If image_path starts with http, it's a full URL
            if (str_starts_with($this->image_path, 'http')) {
                return $this->image_path;
            }
            // Otherwise, it's a local path
            return asset($this->image_path);
        }

        // Return a default image based on product name or ID
        return $this->getDefaultImageUrl();
    }

    /**
     * Get a default image from the public/img directory
     */
    public function getDefaultImageUrl()
    {
        // Special case for Field Operations Guide - use artificial book
        if (stripos($this->name, 'field') !== false && stripos($this->name, 'guide') !== false) {
            return 'artificial-book'; // This will be handled in the frontend
        }

        $defaultImages = $this->getAvailableDefaultImages();
        
        if (empty($defaultImages)) {
            // Fallback to a placeholder if no images in directory
            return 'https://via.placeholder.com/400x300/374151/ffffff?text=' . urlencode($this->name ?: 'Product');
        }

        // Use product ID to consistently assign the same default image
        $imageIndex = $this->id ? ($this->id - 1) % count($defaultImages) : 0;
        return asset('img/' . $defaultImages[$imageIndex]);
    }

    /**
     * Get list of available default images from public/img directory
     */
    public static function getAvailableDefaultImages()
    {
        $imgPath = public_path('img');
        
        if (!File::exists($imgPath)) {
            return [];
        }

        $images = File::files($imgPath);
        $imageNames = [];

        foreach ($images as $image) {
            $extension = strtolower($image->getExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                $imageNames[] = $image->getFilename();
            }
        }

        sort($imageNames); // Consistent ordering
        return $imageNames;
    }

    /**
     * Assign a default image if none is set
     */
    public function assignDefaultImageIfNeeded()
    {
        if (!$this->image_path) {
            // Special case for Field Operations Guide - use artificial book indicator
            if (stripos($this->name, 'field') !== false && stripos($this->name, 'guide') !== false) {
                $this->image_path = 'artificial-book';
                $this->save();
                return;
            }

            $defaultImages = self::getAvailableDefaultImages();
            if (!empty($defaultImages)) {
                $imageIndex = ($this->id - 1) % count($defaultImages);
                $this->image_path = 'img/' . $defaultImages[$imageIndex];
                $this->save();
            }
        }
    }
}
