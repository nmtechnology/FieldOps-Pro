<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;
use Stripe\Price;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a new subscription for a user
     */
    public function createSubscription(User $user, Product $product, string $paymentMethodId)
    {
        try {
            // Create or get Stripe customer
            $stripeCustomer = $this->getOrCreateCustomer($user, $paymentMethodId);

            // Create Stripe subscription
            $stripeSubscription = StripeSubscription::create([
                'customer' => $stripeCustomer->id,
                'items' => [[
                    'price' => $product->stripe_price_id,
                ]],
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Create local subscription record
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'stripe_subscription_id' => $stripeSubscription->id,
                'stripe_customer_id' => $stripeCustomer->id,
                'status' => $stripeSubscription->status,
                'amount' => $product->price,
                'current_period_start' => now()->createFromTimestamp($stripeSubscription->current_period_start),
                'current_period_end' => now()->createFromTimestamp($stripeSubscription->current_period_end),
                'cancel_at_period_end' => false,
            ]);

            return [
                'subscription' => $subscription,
                'client_secret' => $stripeSubscription->latest_invoice->payment_intent->client_secret,
            ];
        } catch (\Exception $e) {
            Log::error('Subscription creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get or create Stripe customer
     */
    private function getOrCreateCustomer(User $user, string $paymentMethodId)
    {
        // Check if user already has a Stripe customer ID
        $existingSubscription = $user->subscriptions()->latest()->first();
        
        if ($existingSubscription && $existingSubscription->stripe_customer_id) {
            $customer = Customer::retrieve($existingSubscription->stripe_customer_id);
            
            // Attach payment method to customer
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $customer->id]);
            
            // Set as default payment method
            Customer::update($customer->id, [
                'invoice_settings' => ['default_payment_method' => $paymentMethodId],
            ]);
            
            return $customer;
        }

        // Create new customer
        return Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'payment_method' => $paymentMethodId,
            'invoice_settings' => [
                'default_payment_method' => $paymentMethodId,
            ],
        ]);
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(Subscription $subscription, bool $immediately = false)
    {
        try {
            if ($immediately) {
                // Cancel immediately
                $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_subscription_id);
                $stripeSubscription->cancel();

                $subscription->update([
                    'status' => 'canceled',
                    'canceled_at' => now(),
                    'ends_at' => now(),
                    'cancel_at_period_end' => false,
                ]);
            } else {
                // Cancel at end of billing period (grace period)
                $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_subscription_id);
                $stripeSubscription->cancel_at_period_end = true;
                $stripeSubscription->save();

                $gracePeriodEnd = $subscription->current_period_end->addDays($subscription->product->grace_period_days);

                $subscription->update([
                    'canceled_at' => now(),
                    'ends_at' => $gracePeriodEnd,
                    'cancel_at_period_end' => true,
                ]);
            }

            return $subscription;
        } catch (\Exception $e) {
            Log::error('Subscription cancellation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Reactivate a canceled subscription
     */
    public function reactivateSubscription(Subscription $subscription)
    {
        try {
            if (!$subscription->canReactivate()) {
                throw new \Exception('This subscription cannot be reactivated');
            }

            // Reactivate in Stripe
            $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_subscription_id);
            
            // If subscription is still active in Stripe, just remove the cancellation
            if ($stripeSubscription->status === 'active') {
                $stripeSubscription->cancel_at_period_end = false;
                $stripeSubscription->save();
            } else {
                // If subscription has ended, create a new one
                return $this->createSubscription(
                    $subscription->user,
                    $subscription->product,
                    $stripeSubscription->default_payment_method
                );
            }

            $subscription->update([
                'status' => 'active',
                'canceled_at' => null,
                'ends_at' => null,
                'cancel_at_period_end' => false,
            ]);

            return ['subscription' => $subscription];
        } catch (\Exception $e) {
            Log::error('Subscription reactivation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update subscription from Stripe webhook
     */
    public function updateFromWebhook(array $stripeSubscription)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription['id'])->first();

        if (!$subscription) {
            return null;
        }

        $subscription->update([
            'status' => $stripeSubscription['status'],
            'current_period_start' => now()->createFromTimestamp($stripeSubscription['current_period_start']),
            'current_period_end' => now()->createFromTimestamp($stripeSubscription['current_period_end']),
        ]);

        return $subscription;
    }

    /**
     * Create or update Stripe Price for a product
     */
    public function createOrUpdatePrice(Product $product)
    {
        try {
            if ($product->stripe_price_id) {
                // Archive the old price
                Price::update($product->stripe_price_id, ['active' => false]);
            }

            // Create new price
            $price = Price::create([
                'unit_amount' => $product->price * 100, // Convert to cents
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => 1,
                ],
                'product_data' => [
                    'name' => $product->name,
                    'description' => $product->short_description,
                ],
            ]);

            $product->update(['stripe_price_id' => $price->id]);

            return $price;
        } catch (\Exception $e) {
            Log::error('Price creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
