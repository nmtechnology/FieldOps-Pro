# FieldOps-Pro Copilot Instructions

## Project Overview
FieldOps-Pro is a Laravel-based e-commerce platform for digital products with integrated Stripe payments, admin dashboard, and guest checkout capabilities. The application follows a dual-checkout pattern (authenticated vs guest users) and uses Inertia.js with Vue 3 for the frontend.

## Architecture & Key Patterns

### Domain Model
- **Core entities**: User, Product, Order, Payment, Discount, ProductContent
- **Product types**: Info products with structured content sections (stored as JSON in `content_sections`)
- **User roles**: Standard users and admins (via `is_admin` boolean flag)
- **Order lifecycle**: pending → completed → refunded (with Stripe webhook integration)

### Route Structure
- `routes/web.php` - Main application routes with guest checkout prefix
- `routes/admin.php` - Admin-only routes (loaded via `admin_web.php` with prefix)
- `routes/auth.php` - Authentication routes (Laravel Breeze)
- **Key pattern**: Routes are grouped by user type (guest vs authenticated vs admin)

### Frontend Stack
- **Inertia.js + Vue 3** - Server-driven SPA architecture
- **TailwindCSS + Tailwind plugins** (@forms, @typography, @vite)
- **Ziggy** - Laravel route helpers in JavaScript
- **Pages location**: `resources/js/Pages/` (follows Inertia conventions)

### Payment Integration
- **Stripe** - Primary payment processor with webhook handling
- **Dual checkout flows**: Guest checkout with optional registration vs authenticated checkout
- **Discount system** - Percentage and fixed-amount discounts with validation
- **ACH payments** - Additional payment method beyond cards

## Development Workflow

### Quick Start Commands
```bash
# Full development environment (runs concurrently)
composer run dev
# Equivalent to: php artisan serve + queue:listen + pail + npm run dev

# Setup from scratch
composer run setup
# Equivalent to: install deps, copy .env, key:generate, migrate, npm install/build

# Run tests
composer run test
```

### Database Patterns
- **Migration naming**: Date-prefixed with descriptive names (e.g., `2025_10_16_042840_create_products_table.php`)
- **Model relationships**: Standard Eloquent patterns with explicit relationship methods
- **Seeding**: Separate seeders for admin users and product content

### Admin System
- **Middleware**: `AdminMiddleware` checks `is_admin` flag, redirects to home on failure
- **Admin controllers**: Namespaced under `App\Http\Controllers\Admin\`
- **Access pattern**: All admin routes require authentication + admin middleware

### Event System
- **User tracking**: `UserEventSubscriber` handles login/logout events for online status
- **Queue integration**: Event subscriber implements `ShouldQueue` for performance

## Code Conventions

### Controllers
- **Checkout pattern**: Separate methods for guest vs authenticated flows (e.g., `checkout()` vs `guestCheckout()`)
- **Payment processing**: Validate → Create Order → Process Payment → Handle Response
- **Inertia responses**: Always return `Inertia::render()` with data arrays

### Models
- **Fillable arrays**: Explicitly define mass-assignable fields
- **Casts**: Use for JSON fields (`content_sections`) and booleans (`active`, `is_admin`)
- **Relationships**: Include both directions with descriptive method names

### Frontend Components
- **File structure**: `resources/js/Pages/` for page components, `Components/` for reusables
- **Layout pattern**: Use Inertia layouts for consistent structure
- **Route helpers**: Use Ziggy's `route()` helper for Laravel route generation

## Integration Points

### Stripe Webhook Handling
- **Endpoint**: `/stripe/webhook` (CSRF-exempt)
- **Controller**: `StripeWebhookController` for payment confirmation
- **Security**: Verify webhook signatures using `STRIPE_WEBHOOK_SECRET`

### Product Content System
- **Content model**: `ProductContent` with ordered sections (`section_order`)
- **Publishing**: Separate published vs draft content via `is_published` flag
- **File handling**: Download system for product-related files

### User Management
- **Profile fields**: Extended user model with additional profile data
- **Online tracking**: Real-time online status via login/logout events
- **Admin toggle**: Simple boolean flag with dedicated toggle endpoint

## Environment & Configuration

### Required Environment Variables
- `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`
- Standard Laravel variables (DB, APP_KEY, etc.)

### Key Config Files
- `config/services.php` - Stripe and external service configuration
- `vite.config.js` - Vue/Inertia asset compilation
- `tailwind.config.js` - CSS framework configuration

When working on this codebase, prioritize understanding the dual-checkout pattern and the relationship between products, orders, and content delivery. The admin system is straightforward but comprehensive, covering all major entities.