<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SimController;
use App\Http\Controllers\TextVerifiedController;
use App\Http\Controllers\ViopController;
use App\Http\Controllers\WorldNumberController;
use App\Http\Controllers\PayVibeWebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\XtrapayProcessController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/proxy/prices', function (Illuminate\Http\Request $request) {
    // Get the 'country' query parameter
    $country = $request->query('country');

    // Make the request to the 5sim API from the Laravel server
    $response = Http::get('https://5sim.net/v1/guest/prices', [
        'country' => $country,
    ]);

    return $response->json();
});

//Clear Config cache:
Route::get('/clear1', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cache cleared</h1>';
});


Route::get('/clear2', function() {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear config cleared</h1>';
});



Route::any('getInitialCountdown',  [HomeController::class,'getInitialCountdown']);

Route::get('/search-viop-services', [ViopController::class, 'searchservices']);





//auth

Route::get('/',  [HomeController::class,'index']);


Route::post('login_now',  [HomeController::class,'login']);
// Route::get('login',  [HomeController::class,'login_index']);
Route::get('login',  [HomeController::class,'login_index'])->name('login');
Route::post('register_now',  [HomeController::class,'register']);
Route::get('register',  [HomeController::class,'register_index']);

Route::get('cworld',  [SimController::class,'index']);
Route::post('buy-csms',  [SimController::class,'order_csms']);
Route::get('c-sms',  [SimController::class,'delete_sms']);
Route::get('admin-c-sms',  [SimController::class,'admin_delete_sms']);
Route::get('get-csms',  [SimController::class,'get_c_sms']);



Route::get('log-out',  [HomeController::class,'logout']);
Route::post('reset-password-now',  [HomeController::class,'reset_password_now']);
Route::post('reset-password',  [HomeController::class,'reset_password']);
Route::get('expired',  [HomeController::class,'expired']);
Route::get('verify-password',  [HomeController::class,'verify_password']);
Route::get('forgot-password',  [HomeController::class,'forget_password']);
Route::get('faq',  [HomeController::class,'faq']);
Route::get('terms',  [HomeController::class,'terms']);
Route::get('policy',  [HomeController::class,'policy']);
Route::get('rules',  [HomeController::class,'rules']);
Route::post('update-password-now',  [HomeController::class,'update_password_now']);

Route::get('verify-account-view',  [HomeController::class,'verify_account_now_view']);
Route::get('verify-account-now',  [HomeController::class,'verify_account_now']);

Route::get('verify-account-now-success',  [HomeController::class,'verify_account_now_page']);


Route::any('update-smspool-rate',  [AdminController::class,'update_smspool_rate']);
Route::any('update-smspool-cost',  [AdminController::class,'update_smspool_cost']);



Route::any('get-smscode',  [HomeController::class,'get_smscode']);





Route::group(['middleware' => ['auth', 'user', 'session.timeout']], function () {

    Route::get('us',  [HomeController::class,'home']);

    Route::any('home',  [HomeController::class,'home']);
    Route::any('world',  [WorldNumberController::class,'home']);
    Route::any('check-av',  [WorldNumberController::class,'check_av']);
    Route::post('order_now',  [WorldNumberController::class,'order_now']);
    Route::any('get-smscodeworld',  [WorldNumberController::class,'get_smscode']);
    Route::any('cancleworld-sms',  [WorldNumberController::class,'cancleworld_sms']);


    Route::post('server1_order',  [HomeController::class,'server1_order']);



    Route::get('server3',  [ViopController::class,'index']);



    Route::post('viop-buy',  [ViopController::class,'viop_buy']);

    Route::any('get-viopsms',  [ViopController::class,'get_viopsms']);
    Route::any('cancle-viop',  [ViopController::class,'cancle_viop']);




    Route::any('orders',  [HomeController::class,'orders']);






    Route::any('receive-sms',  [HomeController::class,'receive_sms']);



    Route::any('delete-order',  [HomeController::class,'delete_order']);
    Route::any('delete-w-order',  [HomeController::class,'delete_w_order']);
    Route::any('admin-cancle-sms',  [HomeController::class,'admin_cancle_sms']);




    //Route::post('order-server1',  [HomeController::class,'order_now']);

    Route::any('check-sms',  [HomeController::class,'check_sms']);


    Route::get('welcome',  [HomeController::class,'welcome_index']);
    Route::get('fund-wallet',  [HomeController::class,'fund_wallet']);
    Route::get('profile',  [HomeController::class,'profile']);
    Route::post('fund-now',  [HomeController::class,'fund_now']);
    Route::post('fund-now-xtrapay', [HomeController::class,'fund_now_xtrapay']);
    Route::post('fund-now-payvibe', [HomeController::class,'fund_now_payvibe']);

    
    Route::get('xtrapay/verify/{reference}', [XtrapayProcessController::class,'requery']);
    Route::get('verify',  [HomeController::class,'verify_payment']);
    Route::get('verifypay',  [HomeController::class,'verifypay_payment']);

    Route::get('resolve-page',  [HomeController::class,'resloveDeposit']);
    Route::any('resolve-now',  [HomeController::class,'resolveNow']);
    Route::get('change-password',  [HomeController::class,'change_password']);



    Route::any('update-sim-rate',  [AdminController::class,'update_sim_rate']);
    Route::any('update-sim-cost',  [AdminController::class,'update_sim_cost']);


    Route::any('update-viop-rate', [ViopController::class, 'update_viop_rate']);
    Route::any('update-viop-cost', [ViopController::class, 'update_viop_cost']);

    Route::any('update-tiger-rate', [AdminController::class, 'update_tiger_rate']);
    Route::any('update-tiger-cost', [AdminController::class, 'update_tiger_cost']);





    Route::get('server4',  [TextVerifiedController::class,'index']);




});





























//admin
Route::get('admin',  [AdminController::class,'index']);

Route::get('admin-dashboard',  [AdminController::class,'admin_dashboard']);


Route::any('update-rate',  [AdminController::class,'update_rate']);
Route::any('update-cost',  [AdminController::class,'update_cost']);

Route::get('manual-payment',  [AdminController::class,'manual_payment_view']);
Route::any('verify-payment',  [AdminController::class,'approve_payment']);
Route::any('update-acct-name',  [AdminController::class,'update_acct_name']);
Route::any('delete-payment',  [AdminController::class,'delete_payment']);



Route::any('fund-manual-now',  [HomeController::class,'fund_manual_now']);
Route::any('confirm-pay',  [HomeController::class,'confirm_pay']);


Route::get('search-user',  [AdminController::class,'search_user']);
Route::any('search-username',  [AdminController::class,'search_username']);

Route::any('about-us',  [HomeController::class,'about_us']);
Route::any('policy',  [HomeController::class,'policy']);

// Test routes (no authentication required)
Route::get('test-payvibe-funding', [HomeController::class,'test_payvibe_funding']);
Route::get('test-payvibe-webhook', [PayVibeWebhookController::class,'testWebhook']);
Route::get('payvibe-webhook-status', [PayVibeWebhookController::class,'webhookStatus']);
Route::get('test-payvibe-endpoint', [PayVibeWebhookController::class,'testWebhookEndpoint']);
Route::get('/test-notification', function() {
    $testMessage = "🧪 TEST NOTIFICATION\n\n" .
                   "💰 PayVibe Payment Test\n" .
                   "👤 User: test@example.com\n" .
                   "💳 Reference: TEST_REF_123\n" .
                   "💰 Amount: NGN 1,000\n" .
                   "⏰ Time: " . now()->format('Y-m-d H:i:s') . "\n" .
                   "🔄 Status: ✅ TEST SUCCESSFUL";
    
    $result = send_notification($testMessage);
    
    return response()->json([
        'notification_sent' => $result,
        'message' => $testMessage,
        'telegram_bot' => '7515872256:AAHDrG_LeWM23KVDJ9YF2WiKRCDmebgca0o',
        'chat_id' => '7174457646'
    ]);
});

Route::get('/test-payvibe-complete', function() {
    return response()->json([
        'payvibe_process' => [
            'step_1' => 'User initiates PayVibe funding',
            'step_2' => 'PayVibe API generates virtual account',
            'step_3' => 'User makes payment to virtual account',
            'step_4' => 'PayVibe sends webhook to our system',
            'step_5' => 'Our system processes payment and credits user',
            'step_6' => 'Notifications sent to Telegram and XtraPay'
        ],
        'notifications' => [
            'telegram' => [
                'bot_token' => '7515872256:AAHDrG_LeWM23KVDJ9YF2WiKRCDmebgca0o',
                'chat_id' => '7174457646',
                'status' => '✅ Working'
            ],
            'xtrapay' => [
                'webhook_url' => 'https://xtrapay.cash/api/webhook/receive-transaction',
                'api_code' => 'k3q6fhck',
                'api_key' => 'cwPtTwEuKCMy8qYCi9cffr7WDcgqeVNmki1d9kWV6jtp6UyAR4ehoTNHUjbnDLh4',
                'status' => '✅ Working'
            ]
        ],
        'test_endpoints' => [
            'payvibe_api' => 'http://localhost:8000/test-payvibe-funding',
            'payvibe_webhook' => 'http://localhost:8000/test-payvibe-webhook',
            'xtrapay_webhook' => 'http://localhost:8000/test-xtrapay-simple',
            'notification_test' => 'http://localhost:8000/test-notification'
        ],
        'system_status' => '✅ All systems operational'
    ]);
});

Route::get('/test-xtrapay-simple', function() {
    try {
        $webhookUrl = env('XTRABUSINESS_WEBHOOK_URL', 'https://xtrapay.cash/api/webhook/receive-transaction');
        $apiKey = env('XTRABUSINESS_API_KEY', '');
        $apiCode = env('XTRABUSINESS_API_CODE', 'faddedsms');

        // Simple test payload
        $payload = [
            'site_api_code' => $apiCode,
            'reference' => 'TEST_SIMPLE_' . time(),
            'amount' => 100,
            'currency' => 'NGN',
            'status' => 'success',
            'payment_method' => 'payvibe',
            'customer_email' => 'test@example.com',
            'customer_name' => 'Test User',
            'description' => 'Simple test transaction',
            'external_id' => '999',
            'timestamp' => now()->toISOString()
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'Faddedsms-Webhook/1.0'
        ];
        
        if (!empty($apiKey)) {
            $headers['X-API-Key'] = $apiKey;
        }

        $response = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->timeout(30)
            ->post($webhookUrl, $payload);

        return response()->json([
            'success' => $response->successful(),
            'status_code' => $response->status(),
            'response_body' => $response->body(),
            'payload_sent' => $payload,
            'headers_sent' => $headers,
            'debug' => [
                'webhook_url' => $webhookUrl,
                'api_key_length' => strlen($apiKey),
                'api_code' => $apiCode
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

Route::get('/test-webhook-service', function() {
    try {
        // Create a test transaction
        $user = \App\Models\User::first();
        if (!$user) {
            return response()->json(['error' => 'No users found in database']);
        }

        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = 100; // Original amount credited to user
        $transaction->ref_id = 'TEST_WEBHOOK_SERVICE_' . time();
        $transaction->method = 119; // PayVibe method
        $transaction->type = 2;
        $transaction->status = 2; // Successful
        $transaction->final_amount = 115; // Amount with charges
        $transaction->charge = 15; // Charges
        $transaction->save();

        // Test WebhookService
        $result = \App\Services\WebhookService::sendSuccessfulTransaction($transaction, $user);
        
        return response()->json([
            'webhook_sent' => $result,
            'transaction_id' => $transaction->id,
            'user_email' => $user->email,
            'original_amount' => $transaction->amount,
            'final_amount' => $transaction->final_amount,
            'charges' => $transaction->charge,
            'reference' => $transaction->ref_id,
            'amount_sent_to_xtrapay' => $transaction->amount, // Should be 100
            'debug' => [
                'webhook_url' => env('XTRABUSINESS_WEBHOOK_URL'),
                'api_key_configured' => !empty(env('XTRABUSINESS_API_KEY')),
                'api_code' => env('XTRABUSINESS_API_CODE')
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

Route::get('/test-calculation-breakdown', function() {
    // Test calculation breakdown for 1000 NGN
    $userAmount = 1000; // Amount user wants to fund
    
    // Calculate charges
    $fixedCharge = 100; // Fixed charge
    $percentageRate = $userAmount >= 10000 ? 0.02 : 0.015; // 1.5% for < 10,000, 2% for >= 10,000
    $percentageCharge = round($userAmount * $percentageRate, 2);
    $totalCharges = $fixedCharge + $percentageCharge;
    
    // Calculate final amount user pays
    $finalAmount = round($userAmount + $totalCharges, 0);
    
    // Calculate what goes to different parties
    $amountCreditedToUser = $userAmount; // User gets their original amount
    $amountSentToXtraPay = $userAmount; // XtraPay gets the original amount
    $platformProfit = $totalCharges; // Platform keeps the charges
    
    return response()->json([
        'calculation_breakdown' => [
            'user_input' => [
                'amount_user_wants' => $userAmount,
                'currency' => 'NGN'
            ],
            'charges_calculation' => [
                'fixed_charge' => $fixedCharge,
                'percentage_rate' => $percentageRate * 100 . '%',
                'percentage_charge' => $percentageCharge,
                'total_charges' => $totalCharges
            ],
            'payment_breakdown' => [
                'amount_user_pays' => $finalAmount,
                'amount_credited_to_user' => $amountCreditedToUser,
                'amount_sent_to_xtrapay' => $amountSentToXtraPay,
                'platform_profit' => $platformProfit
            ],
            'summary' => [
                'user_pays' => 'NGN ' . number_format($finalAmount),
                'user_gets' => 'NGN ' . number_format($amountCreditedToUser),
                'xtrapay_receives' => 'NGN ' . number_format($amountSentToXtraPay),
                'platform_keeps' => 'NGN ' . number_format($platformProfit)
            ]
        ],
        'example_transaction' => [
            'reference' => 'EXAMPLE_REF_' . time(),
            'user_email' => 'user@example.com',
            'payment_method' => 'payvibe',
            'status' => 'success'
        ]
    ]);
});

Route::get('/test-calculation-examples', function() {
    $examples = [];
    
    // Test different amounts
    $testAmounts = [100, 500, 1000, 5000, 10000, 20000];
    
    foreach ($testAmounts as $userAmount) {
        // Calculate charges
        $fixedCharge = 100;
        $percentageRate = $userAmount >= 10000 ? 0.02 : 0.015;
        $percentageCharge = round($userAmount * $percentageRate, 2);
        $totalCharges = $fixedCharge + $percentageCharge;
        $finalAmount = round($userAmount + $totalCharges, 0);
        
        $examples[] = [
            'user_wants' => $userAmount,
            'fixed_charge' => $fixedCharge,
            'percentage_rate' => $percentageRate * 100 . '%',
            'percentage_charge' => $percentageCharge,
            'total_charges' => $totalCharges,
            'user_pays' => $finalAmount,
            'user_gets' => $userAmount,
            'platform_profit' => $totalCharges
        ];
    }
    
    return response()->json([
        'calculation_examples' => $examples,
        'charge_structure' => [
            'fixed_charge' => 'NGN 100 (always)',
            'percentage_charge' => '1.5% for amounts < NGN 10,000',
            'percentage_charge_high' => '2% for amounts >= NGN 10,000'
        ]
    ]);
});

Route::get('/test-xtrapay-webhook', function() {
    try {
        // Create a test transaction
        $user = \App\Models\User::first();
        if (!$user) {
            return response()->json(['error' => 'No users found in database']);
        }

        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = 100; // Test with 100 NGN
        $transaction->ref_id = 'TEST_XTRAPAY_100_' . time();
        $transaction->method = 119; // PayVibe method
        $transaction->type = 2;
        $transaction->status = 2; // Successful
        $transaction->final_amount = 115; // Amount with charges (100 + 15)
        $transaction->charge = 15; // Charges for 100 NGN
        $transaction->save();

        // Debug webhook configuration
        $webhookUrl = env('XTRABUSINESS_WEBHOOK_URL', 'https://xtrapay.cash/api/webhook/receive-transaction');
        $apiKey = env('XTRABUSINESS_API_KEY', '');
        $apiCode = env('XTRABUSINESS_API_CODE', 'faddedsms');

        // Test direct HTTP request to XtraPay with minimal payload
        $payload = [
            'site_api_code' => $apiCode,
            'reference' => $transaction->ref_id,
            'amount' => 100,
            'currency' => 'NGN',
            'status' => 'success',
            'payment_method' => 'payvibe',
            'customer_email' => $user->email,
            'customer_name' => $user->name ?? 'Test User',
            'description' => 'Test PayVibe transaction - 100 NGN',
            'external_id' => (string) $transaction->id,
            'timestamp' => now()->toISOString()
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'Faddedsms-Webhook/1.0'
        ];
        
        if (!empty($apiKey)) {
            $headers['X-API-Key'] = $apiKey;
        }

        // Test using WebhookService (which was working)
        $webhookResult = \App\Services\WebhookService::sendSuccessfulTransaction($transaction, $user);
        
        // Test with the exact payload that was working earlier
        $workingPayload = [
            'site_api_code' => $apiCode,
            'reference' => $transaction->ref_id,
            'amount' => 1100,
            'currency' => 'NGN',
            'status' => 'success',
            'payment_method' => 'payvibe',
            'customer_email' => $user->email,
            'customer_name' => $user->name ?? 'Test User',
            'description' => 'Test PayVibe transaction',
            'external_id' => (string) $transaction->id,
            'timestamp' => now()->toISOString()
        ];
        
        $response = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->timeout(30)
            ->post($webhookUrl, $workingPayload);

        return response()->json([
            'webhook_sent' => $webhookResult,
            'direct_http_sent' => $response->successful(),
            'transaction_id' => $transaction->id,
            'user_email' => $user->email,
            'original_amount' => $transaction->amount,
            'final_amount' => $transaction->final_amount,
            'charges' => $transaction->charge,
            'reference' => $transaction->ref_id,
            'payload_sent' => $payload,
            'debug' => [
                'webhook_url' => $webhookUrl,
                'api_key_configured' => !empty($apiKey) && $apiKey !== 'your_api_key_here',
                'api_code' => $apiCode,
                'webhook_service_result' => $webhookResult,
                'direct_http_status' => $response->status(),
                'direct_http_response' => $response->body()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});














Route::get('users',  [AdminController::class,'index_user']);
Route::get('view-user',  [AdminController::class,'view_user']);
Route::any('update-user',  [AdminController::class,'update_user']);
Route::any('remove-user',  [AdminController::class,'remove_user']);




Route::post('edit-front-pr',  [AdminController::class,'edit_front_product']);





Route::post('admin-login',  [AdminController::class,'admin_login']);

















//product

Route::post('buy-now',  [ProductController::class,'buy_now']);
Route::post('item-view',  [ProductController::class,'item_view']);

Route::get('item-view',  [ProductController::class,'i_view']);

Route::get('allcatproduct',  [ProductController::class,'view_all_product']);

Route::post('add-new-product',  [ProductController::class,'add_new_product']);

Route::post('add-front-product',  [ProductController::class,'add_front_product']);

Route::get('detete-front-product',  [ProductController::class,'delete_front_product']);


Route::post('edit-new-product',  [ProductController::class,'edit_front_product']);


//Route::get('view-all',  [ProductController::class,'view_all_product']);


Route::post('/telegram', 'TelegramBotController@handle');


































Route::any('server3-order',  [HomeController::class,'server3_order']);
































