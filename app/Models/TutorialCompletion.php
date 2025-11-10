<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialCompletion extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quiz_answers',
        'score',
        'completed_at',
    ];

    protected $casts = [
        'quiz_answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
