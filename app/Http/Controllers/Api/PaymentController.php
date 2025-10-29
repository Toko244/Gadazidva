<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $service) {}

    /**
     * Create a new payment
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'payee_id' => ['required', 'exists:users,id'],
            'payable_type' => ['required', 'string'],
            'payable_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string'],
        ]);

        $payment = $this->service->createPayment(array_merge(
            $request->only(['payee_id', 'payable_type', 'payable_id', 'amount', 'description']),
            ['payer_id' => $request->user()->id]
        ));

        return response()->json([
            'message' => __('messages.payment.created'),
            'data' => $payment,
        ], 201);
    }

    /**
     * Process a payment
     */
    public function process(Request $request, int $paymentId): JsonResponse
    {
        $request->validate([
            'payment_method' => ['required', 'in:card,cash,bank_transfer'],
            'payment_gateway' => ['nullable', 'string'],
        ]);

        try {
            $payment = $this->service->processPayment(
                $paymentId,
                $request->payment_method,
                $request->payment_gateway
            );

            return response()->json([
                'message' => __('messages.payment.processed'),
                'data' => $payment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment processing failed: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get user payments
     */
    public function myPayments(Request $request): JsonResponse
    {
        $type = $request->query('type'); // sent, received, or null for all

        $payments = $this->service->getUserPayments($request->user()->id, $type);

        return response()->json(['data' => $payments]);
    }

    /**
     * Calculate platform fee
     */
    public function calculateFee(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $fee = $this->service->calculatePlatformFee($request->amount);

        return response()->json([
            'amount' => $request->amount,
            'platform_fee' => $fee,
            'total' => $request->amount + $fee,
        ]);
    }
}
