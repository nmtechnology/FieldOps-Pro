<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\CoinbaseCommerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CoinbaseWebhookController extends Controller
{
    protected CoinbaseCommerceService $coinbase;

    public function __construct(CoinbaseCommerceService $coinbase)
    {
        $this->coinbase = $coinbase;
    }

    /**
     * Handle Coinbase Commerce webhook
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-CC-Webhook-Signature');

        // Verify webhook signature
        if (!$this->coinbase->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Coinbase webhook signature verification failed');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload, true);

        if (!$event || !isset($event['event']['type'])) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $eventType = $event['event']['type'];
        $chargeData = $event['event']['data'] ?? null;

        Log::info('Coinbase webhook received', [
            'event_type' => $eventType,
            'charge_id' => $chargeData['id'] ?? null,
        ]);

        // Handle different event types
        switch ($eventType) {
            case 'charge:confirmed':
            case 'charge:resolved':
                return $this->handleChargeConfirmed($chargeData);
                
            case 'charge:failed':
                return $this->handleChargeFailed($chargeData);
                
            case 'charge:delayed':
                Log::info('Charge delayed (underpaid)', ['charge' => $chargeData]);
                break;
                
            case 'charge:pending':
                Log::info('Charge pending payment', ['charge' => $chargeData]);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle confirmed/resolved charge (payment successful)
     */
    protected function handleChargeConfirmed(array $chargeData): \Illuminate\Http\JsonResponse
    {
        $metadata = $chargeData['metadata'] ?? [];
        $orderId = $metadata['order_id'] ?? null;

        if (!$orderId) {
            Log::error('No order_id in Coinbase webhook metadata');
            return response()->json(['error' => 'No order ID'], 400);
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('Order not found for Coinbase webhook', ['order_id' => $orderId]);
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update order status
        $order->update(['status' => 'completed']);

        // Update payment status
        $payment = Payment::where('order_id', $order->id)
            ->where('transaction_id', $chargeData['id'])
            ->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'metadata' => json_encode($chargeData),
            ]);
        }

        Log::info('Coinbase payment completed', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'charge_id' => $chargeData['id'],
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle failed charge
     */
    protected function handleChargeFailed(array $chargeData): \Illuminate\Http\JsonResponse
    {
        $metadata = $chargeData['metadata'] ?? [];
        $orderId = $metadata['order_id'] ?? null;

        if (!$orderId) {
            return response()->json(['status' => 'success']);
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update(['status' => 'failed']);

            $payment = Payment::where('order_id', $order->id)
                ->where('transaction_id', $chargeData['id'])
                ->first();

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'metadata' => json_encode($chargeData),
                ]);
            }

            Log::warning('Coinbase payment failed', [
                'order_id' => $order->id,
                'charge_id' => $chargeData['id'],
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
