<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\User;

class WebhookService
{
    /**
     * Send transaction notification to Xtrabusiness
     */
    public static function sendToXtrabusiness(Transaction $transaction, User $user, $status = 'successful')
    {
        try {
            // Xtrabusiness webhook configuration
            $webhookUrl = env('XTRABUSINESS_WEBHOOK_URL', 'https://xtrapay.cash/api/webhook/receive-transaction');
            $apiKey = env('XTRABUSINESS_API_KEY', '');
            $apiCode = env('XTRABUSINESS_API_CODE', 'faddedsms');

            if (empty($webhookUrl) || empty($apiKey)) {
                Log::warning('Xtrabusiness webhook not configured', [
                    'transaction_id' => $transaction->id,
                    'webhook_url' => $webhookUrl,
                    'has_api_key' => !empty($apiKey)
                ]);
                return false;
            }

            // Determine payment method based on transaction method
            $paymentMethod = 'xtrapay';
            $description = 'Deposit via Xtrapay';
            
            if ($transaction->method == 119) { // PayVibe method ID
                $paymentMethod = 'payvibe';
                $description = 'Deposit via PayVibe';
            }

            // Calculate the amount to send to XtraPay Business
            // For PayVibe transactions, use the final_amount (which is already after our charges)
            $amountForXtraPay = $transaction->final_amount ?? $transaction->amount;
            
            if ($transaction->method == 119) { // PayVibe method
                // The final_amount is already the amount after our charges
                // Just round it to the nearest 100 for XtraPay Business
                $amountForXtraPay = round($amountForXtraPay / 100) * 100;
            }
            
            // Prepare the webhook payload
            $payload = [
                'site_api_code' => $apiCode,
                'reference' => $transaction->ref_id,
                'amount' => $amountForXtraPay, // Send the amount after our additional charges
                'currency' => 'NGN',
                'status' => $status === 'successful' ? 'success' : $status,
                'payment_method' => $paymentMethod,
                'customer_email' => $user->email,
                'customer_name' => $user->name,
                'description' => $description,
                'external_id' => (string) $transaction->id,
                'metadata' => [
                    'transaction_id' => $transaction->id,
                    'user_id' => $user->id,
                    'original_amount' => $transaction->amount,
                    'final_amount' => $transaction->final_amount ?? $transaction->amount,
                    'payvibe_net_amount' => $transaction->final_amount ?? $transaction->amount,
                    'our_additional_charges' => $transaction->method == 119 ? ($additionalCharges + $fixedCharge) : 0,
                    'percentage_charge' => $transaction->method == 119 ? $additionalCharges : 0,
                    'fixed_charge' => $transaction->method == 119 ? $fixedCharge : 0,
                    'amount_before_rounding' => $transaction->method == 119 ? ($transaction->final_amount ?? $transaction->amount) - ($additionalCharges + $fixedCharge) : $amountForXtraPay,
                    'amount_sent_to_xtrapay' => $amountForXtraPay,
                    'charge' => $transaction->charge ?? null,
                    'payment_reference' => $transaction->ref_id,
                    'site_name' => 'faddedsms.com',
                    'site_url' => 'https://faddedsms.com'
                ],
                'timestamp' => $transaction->created_at ? $transaction->created_at->toISOString() : now()->toISOString()
            ];

            // Send webhook
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => $apiKey,
                'User-Agent' => 'Faddedsms-Webhook/1.0'
            ])->timeout(30)->post($webhookUrl, $payload);

            // Log the response
            Log::info('Xtrabusiness webhook sent', [
                'transaction_id' => $transaction->id,
                'payment_method' => $paymentMethod,
                'original_amount' => $transaction->amount,
                'payvibe_net_amount' => $transaction->final_amount ?? $transaction->amount,
                'our_additional_charges' => $transaction->method == 119 ? ($additionalCharges + $fixedCharge) : 0,
                'amount_sent_to_xtrapay' => $amountForXtraPay,
                'status_code' => $response->status(),
                'response' => $response->json(),
                'payload' => $payload
            ]);

            // Check if webhook was successful
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['success']) && $responseData['success']) {
                    Log::info('Xtrabusiness webhook successful', [
                        'transaction_id' => $transaction->id,
                        'message' => $responseData['message'] ?? 'Transaction processed'
                    ]);
                    return true;
                } else {
                    Log::error('Xtrabusiness webhook failed', [
                        'transaction_id' => $transaction->id,
                        'error' => $responseData['error'] ?? 'Unknown error'
                    ]);
                    return false;
                }
            } else {
                Log::error('Xtrabusiness webhook HTTP error', [
                    'transaction_id' => $transaction->id,
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Xtrabusiness webhook exception', [
                'transaction_id' => $transaction->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send webhook for failed transactions
     */
    public static function sendFailedTransaction(Transaction $transaction, User $user, $reason = 'Transaction failed')
    {
        return self::sendToXtrabusiness($transaction, $user, 'failed');
    }

    /**
     * Send webhook for pending transactions (when transaction is created)
     */
    public static function sendPendingTransaction(Transaction $transaction, User $user)
    {
        return self::sendToXtrabusiness($transaction, $user, 'pending');
    }

    /**
     * Send webhook for successful transactions
     */
    public static function sendSuccessfulTransaction(Transaction $transaction, User $user)
    {
        return self::sendToXtrabusiness($transaction, $user, 'success');
    }

    /**
     * Retry failed webhooks
     */
    public static function retryFailedWebhooks()
    {
        // This method can be used to retry failed webhook attempts
        // You can implement a queue system for this
        Log::info('Retrying failed webhooks');
    }
} 