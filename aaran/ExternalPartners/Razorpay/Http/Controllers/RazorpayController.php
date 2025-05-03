<?php

namespace Aaran\ExternalPartners\Razorpay\Http\Controllers;

use Aaran\ExternalPartners\Razorpay\Models\RazorPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|integer|min:1',
                'currency' => 'in:INR',
                'receipt' => 'nullable|string',
            ]);

            $api = new Api(
                config('razorpay.razorpay.key'),
                config('razorpay.razorpay.secret')
            );

            $order = $api->order->create([
                'receipt'         => $validated['receipt'] ?? 'order_rcpt_' . uniqid(),
                'amount'          => $validated['amount'],
                'currency'        => $validated['currency'] ?? 'INR',
                'payment_capture' => 1,
            ]);

            return response()->json([
                'order_id' => $order['id'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Razorpay createOrder failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Order creation failed'], 500);
        }
    }



    public function verifyPayment(Request $request)
    {
        try {
            $request->validate([
                'razorpay_order_id' => 'required|string',
                'razorpay_payment_id' => 'required|string',
                'razorpay_signature' => 'required|string',
            ]);

            // Step 1: Verify signature
            $generatedSignature = hash_hmac(
                'sha256',
                $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
                config('razorpay.razorpay.secret')
            );

            if (!hash_equals($generatedSignature, $request->razorpay_signature)) {
                throw new SignatureVerificationError('Invalid signature');
            }

            // Step 2: Fetch payment from Razorpay to get amount and currency
            $api = new Api(
                config('razorpay.razorpay.key'),
                config('razorpay.razorpay.secret')
            );

            $payment = $api->payment->fetch($request->razorpay_payment_id);

            // Optional: check if the order ID matches the payment's order_id
            if ($payment['order_id'] !== $request->razorpay_order_id) {
                throw new \Exception('Order ID mismatch');
            }

            // Step 3: Store verified payment
            RazorPayment::create([
                'order_id' => $payment['order_id'],
                'payment_id' => $payment['id'],
                'signature' => $request->razorpay_signature,
                'amount' => $payment['amount'], // Razorpay amount is in paise
                'currency' => $payment['currency'],
                'status' => $payment['status'],
                'method' => $payment['method'] ?? null,
                'email' => $payment['email'] ?? null,
                'phone' => $payment['contact'] ?? null,
                'description' => $payment['description'] ?? null,
                'user_id' => auth()->id(),
                'tenant_id' => session('tenant_id'),
            ]);

            return response()->json(['success' => true]);
        } catch (SignatureVerificationError $e) {
            Log::warning('Razorpay signature mismatch', ['message' => $e->getMessage()]);
            return response()->json(['success' => false], 400);
        } catch (\Throwable $e) {
            Log::error('Razorpay verification failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Payment verification failed'], 500);
        }
    }
}
