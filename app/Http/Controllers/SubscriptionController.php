<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription');
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'plan' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $user = auth()->user();
        $orderId = 'order_' . Str::random(16);
        
        $response = Http::withHeaders([
            'x-client-id' => config('services.cashfree.app_id'),
            'x-client-secret' => config('services.cashfree.secret_key'),
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json',
        ])->post('https://sandbox.cashfree.com/pg/orders', [
            'order_id' => $orderId,
            'order_amount' => $request->amount,
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
            ],
            'order_meta' => [
                'return_url' => route('subscription.callback') . '?order_id={order_id}',
                'notify_url' => route('subscription.webhook'),
            ],
        ]);

        if ($response->successful()) {
            return response()->json([
                'order_token' => $response->json('payment_session_id')
            ]);
        }

        return response()->json([
            'error' => 'Failed to create order'
        ], 500);
    }

    public function handleCallback(Request $request)
    {
        $orderId = $request->order_id;

        $response = Http::withHeaders([
            'x-client-id' => config('services.cashfree.app_id'),
            'x-client-secret' => config('services.cashfree.secret_key'),
            'x-api-version' => '2022-09-01',
        ])->get("https://sandbox.cashfree.com/pg/orders/{$orderId}");

        if ($response->successful()) {
            $orderDetails = $response->json();
            
            if ($orderDetails['order_status'] === 'PAID') {
                $user = auth()->user();
                $user->is_premium = true;
                $user->save();

                return redirect()->route('dashboard')
                    ->with('success', 'Successfully upgraded to premium!');
            }
        }

        return redirect()->route('subscription')
            ->with('error', 'Payment failed. Please try again.');
    }

    public function handleWebhook(Request $request)
    {
        $signature = $request->header('x-webhook-signature');
        $payload = $request->getContent();

        // Verify webhook signature
        $computedSignature = hash_hmac('sha256', $payload, config('services.cashfree.webhook_secret'));

        if (hash_equals($computedSignature, $signature)) {
            $data = $request->json();
            
            if ($data['event'] === 'ORDER.PAID') {
                $orderId = $data['order']['order_id'];
                $customerId = $data['order']['customer_details']['customer_id'];

                $user = User::find($customerId);
                if ($user) {
                    $user->is_premium = true;
                    $user->save();
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'Invalid signature'], 400);
    }
} 