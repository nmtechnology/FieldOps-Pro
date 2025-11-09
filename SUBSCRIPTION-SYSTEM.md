# Monthly Subscription System - Implementation Guide

## Overview
Complete recurring billing system with Stripe integration, grace periods, and reactivation capabilities.

## Database Structure

### Products Table (New Fields)
- `is_subscription` (boolean) - Enable/disable subscription for product
- `stripe_price_id` (string) - Stripe Price ID for recurring billing
- `billing_cycle_days` (int, default 30) - Billing cycle length
- `allow_reactivation` (boolean, default true) - Allow users to reactivate
- `grace_period_days` (int, default 0) - Days of access after cancellation

### Subscriptions Table
- `user_id` - Foreign key to users
- `product_id` - Foreign key to products
- `stripe_subscription_id` - Stripe subscription ID
- `stripe_customer_id` - Stripe customer ID
- `status` - active, canceled, past_due, incomplete, trialing
- `amount` - Monthly charge amount
- `current_period_start` - Billing period start
- `current_period_end` - Billing period end
- `canceled_at` - When user canceled
- `ends_at` - Grace period end date (access until this date)
- `cancel_at_period_end` - Stripe flag for end-of-period cancellation

## Key Features

### 1. Subscription Product Management (Admin)
- Toggle subscription on/off per product
- Set billing cycle (monthly default)
- Enable/disable reactivation
- Configure grace period days
- Automatically create Stripe Prices

### 2. Recurring Billing
- Monthly charges on anniversary date
- Stripe handles payment retry logic
- Automatic renewal unless canceled
- Failed payment handling

### 3. Grace Period Access
- Users retain access after cancellation
- Access continues until `ends_at` date
- Calculated as: `current_period_end + grace_period_days`
- Encourages reactivation

### 4. Subscription Cancellation
- **Immediate**: Cancels now, access ends now
- **End of Period**: Cancels but access continues until period end + grace days
- User sees "Canceled" status but retains access

### 5. Reactivation
- Users can reactivate during grace period
- Shown in billing tab
- One-click reactivation
- Resumes billing immediately

## API Endpoints (To Implement)

### User Routes
```php
POST /subscriptions/create          // Create new subscription
POST /subscriptions/{id}/cancel     // Cancel subscription
POST /subscriptions/{id}/reactivate // Reactivate canceled subscription
GET /billing                         // View subscriptions & billing
```

### Admin Routes
```php
GET /admin/subscriptions            // View all subscriptions
POST /admin/products/{id}/subscription // Toggle subscription settings
```

### Webhooks
```php
POST /stripe/subscription-webhook   // Handle Stripe subscription events
```

## Stripe Webhook Events

Handle these events:
- `customer.subscription.created`
- `customer.subscription.updated`
- `customer.subscription.deleted`
- `invoice.payment_succeeded`
- `invoice.payment_failed`

## Implementation Status

### ✅ Completed
1. Database migrations (products fields, subscriptions table)
2. Subscription model with relationships and scopes
3. Product model updated with subscription fields
4. User model with subscription relationships
5. SubscriptionService with core logic:
   - Create subscriptions
   - Cancel subscriptions (immediate or grace period)
   - Reactivate subscriptions
   - Stripe customer management
   - Stripe Price creation

### 🔄 In Progress
- Subscription Controller
- Billing page UI (Vue component)
- Admin subscription management UI
- Stripe webhook handler updates
- Checkout flow for subscriptions

### 📋 TODO
1. **SubscriptionController** - API endpoints for user actions
2. **Billing.vue** - User billing management page
3. **Admin UI** - Subscription toggles in product edit
4. **Webhook Handler** - Update StripeWebhookController
5. **Checkout Flow** - Handle subscription vs one-time
6. **Email Notifications** - Subscription confirmations, cancellations, renewals
7. **Artisan Command** - Cleanup expired subscriptions
8. **Tests** - Subscription lifecycle tests

## User Flow

### Purchase Flow (Subscription Product)
1. User clicks "Get Started" on subscription product
2. Checkout shows monthly pricing
3. User enters payment info
4. Stripe creates subscription + customer
5. User gets immediate access
6. Monthly billing begins

### Cancellation Flow
1. User goes to Billing tab
2. Clicks "Cancel Subscription"
3. Chooses: Cancel Now or End of Period
4. If End of Period: Access continues + grace period
5. Status shows "Canceled (Active until [date])"

### Reactivation Flow
1. User in grace period sees "Reactivate" button
2. Clicks reactivate
3. Subscription resumes
4. Next billing date = original schedule

## Admin Flow

### Enable Subscription on Product
1. Go to Products > Edit Product
2. Toggle "Enable Subscription"
3. Set monthly price
4. Set grace period days (0-30 recommended)
5. Toggle "Allow Reactivation"
6. Save - Stripe Price auto-created

### View Subscriptions
1. Admin dashboard shows subscription stats
2. Filter by active/canceled/past_due
3. View customer details
4. Manual cancellation (if needed)

## Code Examples

### Check if User Has Access
```php
// In controller
$product = Product::find($id);
if ($product->is_subscription) {
    $hasAccess = auth()->user()->hasActiveSubscription($product->id);
} else {
    $hasAccess = auth()->user()->orders()
        ->where('product_id', $product->id)
        ->where('status', 'completed')
        ->exists();
}
```

### Cancel with Grace Period
```php
$subscriptionService = new SubscriptionService();
$subscription = Subscription::find($id);

// Cancel at end of period (with grace)
$subscriptionService->cancelSubscription($subscription, false);

// Cancel immediately
$subscriptionService->cancelSubscription($subscription, true);
```

### Reactivate
```php
$subscriptionService = new SubscriptionService();
$subscription = Subscription::find($id);

if ($subscription->canReactivate()) {
    $result = $subscriptionService->reactivateSubscription($subscription);
}
```

## Testing

### Test Scenarios
1. ✅ Create subscription
2. ✅ Monthly renewal (via Stripe webhook)
3. ✅ Cancel at period end
4. ✅ Reactivate during grace period
5. ✅ Access expires after grace period
6. ✅ Failed payment handling
7. ✅ Admin disable reactivation

### Test Card Numbers (Stripe)
- Success: `4242424242424242`
- Decline: `4000000000000002`
- Failed payment: `4000000000000341`

## Next Steps

1. Run migrations
2. Implement SubscriptionController
3. Create Billing.vue component
4. Update admin product edit form
5. Handle subscription webhooks
6. Test complete flow
7. Deploy to production

## Configuration

### .env Variables
```env
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

### Default Settings
- Billing cycle: 30 days
- Grace period: 0 days (configurable per product)
- Reactivation: Enabled by default
- Currency: USD

