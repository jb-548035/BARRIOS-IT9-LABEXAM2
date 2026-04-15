<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Payment Details') }}</h2>
            <a href="{{ route('payments.index') }}" class="btn btn-brand-secondary">Back to Payments</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid var(--brand-primary);">
                    <div class="card-header bg-brand-primary-10">
                        <strong class="text-brand-dark">Payment Information</strong>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt class="fw-semibold text-brand-dark">Payment #:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $payment->payment_number }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Order #:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $payment->order?->order_number ?? 'N/A' }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Method:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $payment->getPaymentMethodLabel() }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Status:</dt>
                            <dd class="ms-3">
                                <span class="badge {{ $payment->status === 'paid' ? 'badge-brand-accent' : ($payment->status === 'partial' ? 'badge-brand-light' : 'badge-brand-secondary') }} p-2">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid var(--brand-accent);">
                    <div class="card-header bg-brand-accent-10">
                        <strong class="text-brand-dark">Amounts</strong>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt class="fw-semibold text-brand-dark">Amount Paid:</dt>
                            <dd class="ms-3 text-brand-accent fw-semibold fs-5">₱{{ number_format($payment->amount_paid, 2) }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Change:</dt>
                            <dd class="ms-3 text-brand-secondary">₱{{ number_format($payment->change_amount, 2) }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Paid At:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $payment->paid_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-brand-light">
            <div class="card-header bg-brand-light-20">
                <strong class="text-brand-dark">Notes</strong>
            </div>
            <div class="card-body">
                <p class="mb-0 text-brand-secondary">{{ $payment->notes ?: 'No notes provided.' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
