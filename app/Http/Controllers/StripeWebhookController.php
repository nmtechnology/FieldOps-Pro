<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Mail\OrderPlacedAdmin;
use App\Mail\PurchaseConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Stripe\Stripe;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook.secret');
        
        try {
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Verify the webhook signature
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            
            // Handle the event
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($event->data->object);
                    break;
                case 'payment_intent.payment_failed':
                    $this->handlePaymentIntentFailed($event->data->object);
                    break;
                case 'charge.refunded':
                    $this->handleChargeRefunded($event->data->object);
                    break;
                // Add more event types as needed
                default:
                    Log::info('Received unhandled Stripe event: ' . $event->type);
            }
            
            return response()->json(['status' => 'success']);
            
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Log::error('Error processing Stripe webhook: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        Log::info('Payment Intent Succeeded: ' . $paymentIntent->id);
        
        // Find the associated payment record
        $payment = Payment::where('payment_id', $paymentIntent->id)->first();
        
        if ($payment) {
            // Update payment status
            $payment->status = 'completed';
            $payment->paid_at = now();
            $payment->save();
            
            // Update order status
            $order = Order::find($payment->order_id);
            if ($order) {
                $order->status = 'completed';
                $order->save();
                
                // Send email notifications
                try {
                    // Notify admin
                    Mail::to(config('mail.admin_email', 'admin@fieldengineerpro.com'))
                        ->send(new OrderPlacedAdmin($order));
                    
                    // Notify customer
                    if ($order->user && $order->user->email) {
                        Mail::to($order->user->email)
                            ->send(new PurchaseConfirmation($order));
                    }
                    
                    Log::info('Order notification emails sent for order #' . $order->order_number);
                } catch (\Exception $e) {
                    Log::error('Failed to send order emails: ' . $e->getMessage());
                    // Don't fail the webhook if email fails
                }
            }
        }
    }
    
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        Log::info('Payment Intent Failed: ' . $paymentIntent->id);
        
        // Find the associated payment record
        $payment = Payment::where('payment_id', $paymentIntent->id)->first();
        
        if ($payment) {
            // Update payment status
            $payment->status = 'failed';
            $payment->save();
            
            // Update order status
            $order = Order::find($payment->order_id);
            if ($order) {
                $order->status = 'failed';
                $order->save();
            }
        }
    }
    
    protected function handleChargeRefunded($charge)
    {
        Log::info('Charge Refunded: ' . $charge->id);
        
        // Find the associated payment by payment intent ID
        $payment = Payment::where('payment_id', $charge->payment_intent)->first();
        
        if ($payment) {
            // Update payment status
            $payment->status = 'refunded';
            $payment->refunded_at = now();
            $payment->save();
            
            // Update order status
            $order = Order::find($payment->order_id);
            if ($order) {
                $order->status = 'refunded';
                $order->save();
            }
        }
    }
}
