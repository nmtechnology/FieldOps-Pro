<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'status',
        'amount',
        'current_period_start',
        'current_period_end',
        'canceled_at',
        'ends_at',
        'cancel_at_period_end',
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'canceled_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancel_at_period_end' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this subscription
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && now()->lte($this->current_period_end);
    }

    /**
     * Check if subscription is canceled but still in grace period
     */
    public function onGracePeriod(): bool
    {
        return $this->canceled_at !== null && now()->lte($this->ends_at);
    }

    /**
     * Check if user has access (active or on grace period)
     */
    public function hasAccess(): bool
    {
        return $this->isActive() || $this->onGracePeriod();
    }

    /**
     * Check if subscription can be reactivated
     */
    public function canReactivate(): bool
    {
        return $this->canceled_at !== null 
            && now()->lte($this->ends_at)
            && $this->product->allow_reactivation;
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for canceled subscriptions
     */
    public function scopeCanceled($query)
    {
        return $query->whereNotNull('canceled_at');
    }

    /**
     * Scope for subscriptions with access (active or grace period)
     */
    public function scopeWithAccess($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'active')
              ->orWhere(function($q2) {
                  $q2->whereNotNull('canceled_at')
                     ->where('ends_at', '>=', now());
              });
        });
    }
}
