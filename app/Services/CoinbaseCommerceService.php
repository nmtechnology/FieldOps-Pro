<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class CoinbaseCommerceService
{
    protected Client $client;
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.coinbase.api_key');
        $this->apiUrl = config('services.coinbase.api_url');
        
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'X-CC-Api-Key' => $this->apiKey,
                'X-CC-Version' => '2018-03-22',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Create a charge for crypto payment
     *
     * @param array $data
     * @return array|null
     */
    public function createCharge(array $data): ?array
    {
        try {
            $response = $this->client->post('/charges', [
                'json' => $data,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            return $body['data'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Coinbase Commerce charge creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            
            return null;
        }
    }

    /**
     * Get charge details by ID
     *
     * @param string $chargeId
     * @return array|null
     */
    public function getCharge(string $chargeId): ?array
    {
        try {
            $response = $this->client->get("/charges/{$chargeId}");
            
            $body = json_decode($response->getBody()->getContents(), true);
            
            return $body['data'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Coinbase Commerce charge retrieval failed', [
                'error' => $e->getMessage(),
                'charge_id' => $chargeId,
            ]);
            
            return null;
        }
    }

    /**
     * Verify webhook signature
     *
     * @param string $payload
     * @param string $signature
     * @return bool
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $webhookSecret = config('services.coinbase.webhook_secret');
        
        $computedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($computedSignature, $signature);
    }
}
