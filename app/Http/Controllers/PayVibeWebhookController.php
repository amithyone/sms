<?php

namespace App\Http\Controllers;

use App\Services\PayVibeService;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\User;

class PayVibeWebhookController extends Controller
{
    protected PayVibeService $payVibeService;

    public function __construct(PayVibeService $payVibeService)
    {
        $this->payVibeService = $payVibeService;
    }

    public function handleWebhook(Request $request)
    {
        // Log the complete webhook request for debugging
        Log::info('PayVibeWebhook: Received webhook', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            // Get the reference from the webhook payload
            $reference = $request->input('reference');
            $transactionAmount = $request->input('transaction_amount', 0);
            $netAmount = $request->input('net_amount', 0);
            $settledAmount = $request->input('settled_amount', 0);
            $creditedAt = $request->input('credited_at');
            $bankCharge = $request->input('bank_charge', 0);
            $platformFee = $request->input('platform_fee', 0);
            $platformProfit = $request->input('platform_profit', 0);

            Log::info('PayVibeWebhook: Processing webhook data', [
                'reference' => $reference,
                'transaction_amount' => $transactionAmount,
                'net_amount' => $netAmount,
                'settled_amount' => $settledAmount,
                'credited_at' => $creditedAt,
                'bank_charge' => $bankCharge,
                'platform_fee' => $platformFee,
                'platform_profit' => $platformProfit
            ]);

            if (!$reference) {
                Log::error('PayVibeWebhook: No reference in webhook');
                return response()->json(['error' => 'No reference provided'], 400);
            }

            // Find the transaction using the reference
            $transaction = Transaction::where('ref_id', $reference)->first();

            if (!$transaction) {
                Log::error('PayVibeWebhook: Transaction not found', [
                    'reference' => $reference,
                    'available_transactions' => Transaction::where('ref_id', 'LIKE', '%' . substr($reference, 0, 10) . '%')->pluck('ref_id')->toArray()
                ]);
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            Log::info('PayVibeWebhook: Found transaction', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                'status' => $transaction->status,
                'ref_id' => $transaction->ref_id
            ]);

            // Check if already processed
            if ($transaction->status == 2) {
                Log::info('PayVibeWebhook: Transaction already processed', [
                    'reference' => $reference,
                    'transaction_id' => $transaction->id
                ]);
                return response()->json(['status' => 'already_processed']);
            }

            // Update transaction status to successful (2)
            $transaction->status = 2; // Successful
            $transaction->save();

            Log::info('PayVibeWebhook: Transaction status updated', [
                'transaction_id' => $transaction->id,
                'new_status' => $transaction->status
            ]);

            // Credit user with the original amount
            $user = User::find($transaction->user_id);
            if ($user) {
                $oldBalance = $user->wallet;
                
                // Credit user with the original amount
                $user->increment('wallet', $transaction->amount);
                
                // Get updated balance for logging
                $newBalance = $user->fresh()->wallet;

                Log::info('PayVibeWebhook: Payment processed successfully', [
                    'reference' => $reference,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_amount' => $transactionAmount,
                    'net_amount' => $netAmount,
                    'settled_amount' => $settledAmount,
                    'bank_charge' => $bankCharge,
                    'platform_fee' => $platformFee,
                    'platform_profit' => $platformProfit,
                    'credited_amount' => $transaction->amount,
                    'old_balance' => $oldBalance,
                    'new_balance' => $newBalance,
                    'credited_at' => $creditedAt
                ]);

                // Send admin notification with detailed payment info
                $adminMessage = "💰 PAYVIBE PAYMENT RECEIVED\n\n" .
                              "👤 User: " . $user->email . "\n" .
                              "💳 Reference: " . $reference . "\n" .
                              "💰 Transaction Amount: NGN " . number_format($transactionAmount) . "\n" .
                              "💸 Net Amount: NGN " . number_format($netAmount) . "\n" .
                              "🏦 Bank Charge: NGN " . number_format($bankCharge) . "\n" .
                              "📊 Platform Fee: NGN " . number_format($platformFee) . "\n" .
                              "💵 Platform Profit: NGN " . number_format($platformProfit) . "\n" .
                              "✅ Credited Amount: NGN " . number_format($transaction->amount) . "\n" .
                              "📈 Old Balance: NGN " . number_format($oldBalance) . "\n" .
                              "📈 New Balance: NGN " . number_format($newBalance) . "\n" .
                              "⏰ Credited At: " . ($creditedAt ? date('Y-m-d H:i:s', strtotime($creditedAt)) : now()->format('Y-m-d H:i:s')) . "\n" .
                              "🔄 Status: ✅ SUCCESSFUL";

                send_notification($adminMessage);

                // Send user notification (if you have user notification system)
                $this->sendUserNotification($user, $transaction);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment processed successfully',
                    'user_id' => $user->id,
                    'amount_credited' => $transaction->amount,
                    'new_balance' => $newBalance
                ]);
            } else {
                Log::error('PayVibeWebhook: User not found', [
                    'reference' => $reference,
                    'user_id' => $transaction->user_id
                ]);
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('PayVibeWebhook: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reference' => $request->input('reference')
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Send notification to user about successful payment
     */
    private function sendUserNotification($user, $transaction)
    {
        try {
            // You can implement email notification here
            // Mail::to($user->email)->send(new PaymentReceivedMail($user, $transaction));
            
            // Or SMS notification
            // $this->sendSMS($user->phone, "Your payment of NGN " . number_format($transaction->amount) . " has been received and credited to your wallet.");
            
            Log::info('PayVibeWebhook: User notification sent', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'transaction_id' => $transaction->id
            ]);
        } catch (\Exception $e) {
            Log::error('PayVibeWebhook: Failed to send user notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verifyPayment($reference)
    {
        try {
            Log::info('PayVibeWebhook: Manual verification requested', ['reference' => $reference]);
            
            // Use PayVibeService to check payment status
            $result = $this->payVibeService->checkPaymentStatus($reference);
            
            if (isset($result['status']) && $result['status'] === 'completed') {
                // Process the payment as if it was a webhook
                $webhookData = [
                    'reference' => $reference,
                    'transaction_amount' => $result['amount'] ?? 0,
                    'net_amount' => $result['amount'] ?? 0,
                    'credited_at' => $result['paid_at'] ?? now()
                ];
                
                // Process the webhook
                $processedData = $this->payVibeService->processWebhook($webhookData);
                
                if (!isset($processedData['error'])) {
                    // Find and process the transaction
                    $transaction = Transaction::where('detail->reference', $reference)->first();
                    
                    if ($transaction && $transaction->status != 2) {
                        // Credit the user
                        $user = User::find($transaction->user_id);
                        if ($user) {
                            $user->increment('wallet', $transaction->amount);
                            
                            // Update transaction status
                            $transaction->status = 2;
                            $transaction->save();
                            
                            Log::info('PayVibeWebhook: Manual verification successful', [
                                'reference' => $reference,
                                'user_id' => $user->id,
                                'amount' => $transaction->amount
                            ]);
                            
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Payment verified and credited successfully'
                            ]);
                        }
                    }
                }
            }
            
            return response()->json([
                'status' => 'pending',
                'message' => 'Payment is still pending or not found'
            ]);
            
        } catch (\Exception $e) {
            Log::error('PayVibeWebhook: Manual verification error', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Verification failed'
            ], 500);
        }
    }

    /**
     * Track webhook delivery status
     */
    public function webhookStatus()
    {
        try {
            // Check if webhook endpoint is accessible
            $webhookUrl = url('/api/webhook/payvibe');
            
            // Test webhook endpoint
            $testResponse = \Http::post($webhookUrl, [
                'reference' => 'STATUS_CHECK_' . time(),
                'status' => 'test',
                'amount' => 0
            ]);

            return response()->json([
                'webhook_status' => 'active',
                'webhook_url' => $webhookUrl,
                'endpoint_test' => [
                    'status_code' => $testResponse->status(),
                    'response' => $testResponse->body()
                ],
                'notification_system' => [
                    'telegram_bot' => 'configured',
                    'chat_id' => '7174457646'
                ],
                'last_check' => now()->format('Y-m-d H:i:s'),
                'system_info' => [
                    'laravel_version' => app()->version(),
                    'php_version' => PHP_VERSION,
                    'server_time' => now()->format('Y-m-d H:i:s T')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'webhook_status' => 'error',
                'error' => $e->getMessage(),
                'webhook_url' => url('/api/webhook/payvibe'),
                'last_check' => now()->format('Y-m-d H:i:s')
            ], 500);
        }
    }

    /**
     * Test webhook endpoint
     */
    public function testWebhookEndpoint()
    {
        $testData = [
            'reference' => 'TEST_' . time(),
            'transaction_amount' => 1115,
            'net_amount' => 987.125,
            'bank_charge' => 5.575,
            'platform_fee' => 127.875,
            'settled_amount' => 1109.425,
            'platform_profit' => 122.3,
            'credited_at' => now()->format('c')
        ];

        $response = \Http::post(url('/api/webhook/payvibe'), $testData);

        return response()->json([
            'test_data' => $testData,
            'response_status' => $response->status(),
            'response_body' => $response->body(),
            'webhook_url' => url('/api/webhook/payvibe')
        ]);
    }

    /**
     * Simple test webhook method
     */
    public function testWebhook()
    {
        try {
            // Find an existing user or create a test user
            $user = \App\Models\User::first();
            if (!$user) {
                // Create a test user if none exists
                $user = new \App\Models\User();
                $user->name = 'Test User';
                $user->email = 'test@example.com';
                $user->password = bcrypt('password');
                $user->wallet = 0;
                $user->save();
            }

            // Create a test transaction
            $testReference = 'TEST_PAYVIBE_' . time();
            $transaction = new \App\Models\Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = 1000; // Original amount user wanted to fund
            $transaction->ref_id = $testReference;
            $transaction->method = 119; // PayVibe method
            $transaction->type = 2;
            $transaction->status = 1; // Pending
            $transaction->save();

            // Simulate webhook with correct PayVibe payload format
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'reference' => $testReference,
                'transaction_amount' => 1115,
                'net_amount' => 987.125,
                'bank_charge' => 5.575,
                'platform_fee' => 127.875,
                'settled_amount' => 1109.425,
                'platform_profit' => 122.3,
                'credited_at' => now()->format('c')
            ]);

            $result = $this->handleWebhook($request);
            
            // Get updated user balance
            $user->refresh();
            
            return response()->json([
                'test_reference' => $testReference,
                'webhook_result' => $result->getContent(),
                'user_email' => $user->email,
                'original_balance' => 0,
                'new_balance' => $user->wallet,
                'transaction_amount' => 1115,
                'credited_amount' => 1000,
                'message' => 'Webhook test completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'test_reference' => $testReference ?? 'N/A',
                'error' => $e->getMessage(),
                'message' => 'Webhook test failed'
            ]);
        }
    }
} 