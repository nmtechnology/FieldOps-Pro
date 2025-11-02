<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContentProgress extends Model
{
    protected $fillable = [
        'user_id',
        'product_content_id',
        'completed',
        'completed_at',
        'time_spent_seconds',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productContent()
    {
        return $this->belongsTo(ProductContent::class);
    }
}
