<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Create a new payment
     */
    public function createPayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $payment = Payment::create(array_merge($data, [
                'transaction_id' => $this->generateTransactionId(),
                'status' => 'pending',
            ]));

            return $payment->load(['payer', 'payee']);
        });
    }

    /**
     * Process payment (simplified - in production would integrate with payment gateway)
     */
    public function processPayment(int $paymentId, string $paymentMethod, ?string $gateway = null): Payment
    {
        return DB::transaction(function () use ($paymentId, $paymentMethod, $gateway) {
            $payment = Payment::findOrFail($paymentId);

            $payment->update([
                'status' => 'processing',
                'payment_method' => $paymentMethod,
                'payment_gateway' => $gateway,
            ]);

            // Here you would integrate with actual payment gateway
            // For now, we'll simulate success
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            return $payment->load(['payer', 'payee']);
        });
    }

    /**
     * Mark payment as completed
     */
    public function markAsCompleted(int $paymentId): bool
    {
        $payment = Payment::findOrFail($paymentId);
        
        return $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(int $paymentId, ?string $reason = null): bool
    {
        $payment = Payment::findOrFail($paymentId);
        
        return $payment->update([
            'status' => 'failed',
            'metadata' => array_merge($payment->metadata ?? [], ['failure_reason' => $reason]),
        ]);
    }

    /**
     * Refund payment
     */
    public function refundPayment(int $paymentId, ?string $reason = null): bool
    {
        $payment = Payment::findOrFail($paymentId);

        if ($payment->status !== 'completed') {
            throw new \Exception('Can only refund completed payments');
        }

        return $payment->update([
            'status' => 'refunded',
            'metadata' => array_merge($payment->metadata ?? [], ['refund_reason' => $reason]),
        ]);
    }

    /**
     * Get payments by user (either as payer or payee)
     */
    public function getUserPayments(int $userId, ?string $type = null)
    {
        $query = Payment::where('payer_id', $userId)
            ->orWhere('payee_id', $userId);

        if ($type === 'sent') {
            $query = Payment::where('payer_id', $userId);
        } elseif ($type === 'received') {
            $query = Payment::where('payee_id', $userId);
        }

        return $query->with(['payer', 'payee', 'payable'])
            ->latest()
            ->get();
    }

    /**
     * Generate unique transaction ID
     */
    protected function generateTransactionId(): string
    {
        do {
            $transactionId = 'TXN-' . strtoupper(Str::random(12));
        } while (Payment::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    /**
     * Calculate platform fee (example: 5% of transaction)
     */
    public function calculatePlatformFee(float $amount): float
    {
        $feePercentage = 0.05; // 5%
        return round($amount * $feePercentage, 2);
    }
}
