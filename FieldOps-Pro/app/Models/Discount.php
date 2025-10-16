<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'used',
        'active',
        'valid_from',
        'valid_until',
        'description',
    ];

    protected $casts = [
        'active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid()
    {
        $now = now();
        return $this->active && 
               ($this->valid_from === null || $now >= $this->valid_from) && 
               ($this->valid_until === null || $now <= $this->valid_until) &&
               ($this->max_uses === null || $this->used < $this->max_uses);
    }
}
