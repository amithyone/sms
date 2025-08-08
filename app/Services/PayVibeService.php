<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayVibeService
{
    private string $baseUrl;
    private string $publicKey;
    private string $secretKey;
    private string $productIdentifier = 'fadded_sms';

    public function __construct()
    {
        $this->baseUrl = config('services.payvibe.base_url', 'https://payvibeapi.six3tech.com/api');
        $this->publicKey = config('services.payvibe.public_key', '');
        $this->secretKey = config('services.payvibe.secret_key', '');
        $this->productIdentifier = config('services.payvibe.product_identifier', 'fadded_sms');
    }

    public function initiateFunding(float $amount): array
    {
        $reference = $this->generateReference();
        
        // Check if required credentials are set
        if (empty($this->publicKey) || empty($this->secretKey)) {
            Log::error('PayVibeService: Missing credentials', [
                'has_public_key' => !empty($this->publicKey),
                'has_secret_key' => !empty($this->secretKey)
            ]);
            
            return [
                'error' => true,
                'message' => 'PayVibe service is not configured. Please contact support.',
                'reference' => $reference
            ];
        }
        
        try {
            $payload = [
                'reference' => $reference,
                'product_identifier' => $this->productIdentifier,
                //'amount' => $amount // Send amount in Naira, not kobo
            ];
            
            Log::info('PayVibeService: Making API request', [
                'url' => $this->baseUrl . '/v1/payments/virtual-accounts/initiate',
                'payload' => $payload,
                'base_url' => $this->baseUrl,
                'product_identifier' => $this->productIdentifier
            ]);
            
            // Try different authentication methods
            $authMethods = [
                ['Authorization' => 'Bearer ' . $this->secretKey],
                ['Authorization' => $this->secretKey],
                ['X-API-Key' => $this->secretKey],
                ['api-key' => $this->secretKey],
                ['x-api-key' => $this->secretKey],
                ['X-PayVibe-Key' => $this->secretKey],
                ['PayVibe-Key' => $this->secretKey],
                ['key' => $this->secretKey],
                ['Authorization' => 'Bearer ' . $this->publicKey],
                ['X-API-Key' => $this->publicKey],
                ['api-key' => $this->publicKey],
                // Try without any auth header to see the exact error
                [],
            ];
            
            $response = null;
            $lastError = null;
            $lastStatusCode = null;
            
            foreach ($authMethods as $index => $headers) {
                $fullHeaders = array_merge($headers, [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]);
                
                Log::info("PayVibeService: Trying authentication method " . ($index + 1), [
                    'method' => $index + 1,
                    'headers' => array_keys($headers),
                    'has_secret_key' => !empty($this->secretKey),
                    'has_public_key' => !empty($this->publicKey)
                ]);
                
                $response = Http::timeout(30)
                    ->withHeaders($fullHeaders)
                    ->post($this->baseUrl . '/v1/payments/virtual-accounts/initiate', $payload);
                    
                $lastStatusCode = $response->status();
                
                Log::info("PayVibeService: Response for method " . ($index + 1), [
                    'method' => $index + 1,
                    'status_code' => $lastStatusCode,
                    'response_body' => $response->body()
                ]);
                
                // If successful, break
                if ($response->successful()) {
                    Log::info("PayVibeService: Successful authentication method found", [
                        'method' => $index + 1,
                        'headers_used' => array_keys($headers)
                    ]);
                    break;
                }
                
                // If we get a specific error about wallet split, that's a configuration issue
                if (strpos($response->body(), 'Wallet split has not been configured') !== false) {
                    $lastError = 'Wallet split has not been configured for this payment. Please contact support.';
                    break;
                }
                
                // If we get a 401 with "API key is missing", continue trying other methods
                if ($response->status() === 401 && strpos($response->body(), 'API key is missing') !== false) {
                    $lastError = $response->body();
                    continue;
                }
                
                $lastError = $response->body();
            }
                
            if ($response && $response->successful()) {
                $responseData = $response->json();
                Log::info('PayVibeService: Parsed response data', $responseData);
                
                // PayVibe returns status as boolean (true/false), not string ('success'/'error')
                if (isset($responseData['status']) && $responseData['status'] === true && isset($responseData['data'])) {
                    $accountData = $responseData['data'];
                    return [
                        'reference' => $accountData['reference'] ?? $reference,
                        'accountNumber' => $accountData['virtual_account_number'] ?? null,
                        'bank' => $accountData['bank_name'] ?? null,
                        'accountName' => $accountData['account_name'] ?? null,
                        'amount' => $accountData['amount'] ?? $amount,
                        'message' => "Please transfer ₦{$amount} to the bank details above.",
                        'expiry' => 600
                    ];
                } else {
                    Log::error('PayVibeService: API returned error', [
                        'response_data' => $responseData,
                        'status' => $responseData['status'] ?? 'unknown'
                    ]);
                    
                    return [
                        'error' => true,
                        'message' => 'Payment service temporarily unavailable. Please try again later.',
                        'reference' => $reference,
                        'api_error' => $responseData['message'] ?? 'Unknown Error'
                    ];
                }
            } else {
                Log::error('PayVibeService: All authentication methods failed', [
                    'last_error' => $lastError,
                    'last_status_code' => $lastStatusCode,
                    'total_methods_tried' => count($authMethods)
                ]);
                
                return [
                    'error' => true,
                    'message' => $lastError ?: 'Payment service temporarily unavailable. Please try again later.',
                    'reference' => $reference,
                    'http_error' => $lastStatusCode ?? 'unknown'
                ];
            }
        } catch (\Exception $e) {
            Log::error('PayVibeService: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => true,
                'message' => 'Payment service temporarily unavailable. Please try again later.',
                'reference' => $reference,
                'exception' => $e->getMessage()
            ];
        }
    }

    public function checkPaymentStatus(string $reference): array
    {
        try {
            $payload = [
                'reference' => $reference,
                'product_identifier' => $this->productIdentifier
            ];
            
            Log::info('PayVibeService: Checking payment status', [
                'url' => $this->baseUrl . '/v1/payments/virtual-accounts/verify',
                'payload' => $payload
            ]);
            
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            
            // Add authentication headers if available
            if (!empty($this->secretKey)) {
                $headers['Authorization'] = 'Bearer ' . $this->secretKey;
            }
            
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->withoutVerifying()
                ->post($this->baseUrl . '/v1/payments/virtual-accounts/verify', $payload);
                
            Log::info('PayVibeService: Status check response', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['status']) && ($responseData['status'] === 'success' || $responseData['status'] === true) && isset($responseData['data'])) {
                    $paymentData = $responseData['data'];
                    $status = $paymentData['status'] ?? 'pending';
                    
                    return [
                        'status' => $status,
                        'amount' => $paymentData['amount'] ?? 0,
                        'reference' => $paymentData['reference'] ?? $reference,
                        'paid_at' => $paymentData['paid_at'] ?? null,
                        'message' => $this->getStatusMessage($status)
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Unable to check payment status',
                        'reference' => $reference
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Payment status check failed',
                    'reference' => $reference
                ];
            }
        } catch (\Exception $e) {
            Log::error('PayVibeService: Status check exception', [
                'message' => $e->getMessage(),
                'reference' => $reference
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Payment status check failed',
                'reference' => $reference
            ];
        }
    }

    public function verifyPayment(string $reference): array
    {
        return $this->checkPaymentStatus($reference);
    }

    public function processWebhook($payload): array
    {
        try {
            Log::info('PayVibeService: Processing webhook', $payload);
            
            // PayVibe webhook payload structure
            if (!isset($payload['reference']) || !isset($payload['transaction_amount'])) {
                return [
                    'error' => true,
                    'message' => 'Invalid webhook payload - missing required fields'
                ];
            }
            
            $reference = $payload['reference'];
            $transactionAmount = $payload['transaction_amount'];
            $netAmount = $payload['net_amount'] ?? $transactionAmount;
            $creditedAt = $payload['credited_at'] ?? now();
            
            // Since this is a webhook notification, the payment was successful
            $status = 'completed';
            
            // Find the pending or failed transaction to get the base amount
            // Search by PayVibe API reference stored in detail field
            $transaction = \App\Models\Transaction::where('detail->reference', $reference)
                ->whereIn('status', [1, 0]) // pending or failed
                ->first();
            
            if ($transaction) {
                // Use the base amount from the transaction (what user originally requested)
                $baseAmount = $transaction->amount;
                Log::info('PayVibeService: Found transaction, using base amount', [
                    'reference' => $reference,
                    'base_amount' => $baseAmount,
                    'net_amount' => $netAmount,
                    'transaction_amount' => $transactionAmount,
                    'transaction_id' => $transaction->id
                ]);
            } else {
                // If no transaction found, use the transaction amount from webhook
                $baseAmount = $transactionAmount;
                Log::warning('PayVibeService: No transaction found, using webhook amount', [
                    'reference' => $reference,
                    'base_amount' => $baseAmount,
                    'net_amount' => $netAmount,
                    'transaction_amount' => $transactionAmount
                ]);
            }
            
            return [
                'reference' => $reference,
                'status' => $status,
                'amount' => $baseAmount, // Use base amount for wallet crediting
                'transaction_amount' => $transactionAmount,
                'net_amount' => $netAmount,
                'paid_at' => $creditedAt,
                'message' => $this->getStatusMessage($status)
            ];
        } catch (\Exception $e) {
            Log::error('PayVibeService: Webhook processing error', [
                'message' => $e->getMessage(),
                'payload' => $payload
            ]);
            
            return [
                'error' => true,
                'message' => 'Webhook processing failed'
            ];
        }
    }

    private function getStatusMessage(string $status): string
    {
        return match($status) {
            'completed', 'success' => 'Payment completed successfully',
            'pending' => 'Payment is pending',
            'failed' => 'Payment failed',
            'expired' => 'Payment expired',
            default => 'Payment status unknown'
        };
    }

    private function generateReference(): string
    {
        return 'PAYVIBE_' . time() . '_' . rand(1000, 9999);
    }
} 