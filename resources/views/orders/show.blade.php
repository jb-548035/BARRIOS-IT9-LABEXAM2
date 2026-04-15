<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Order Details') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-brand-secondary">Back to Orders</a>
                @if(optional($order->payment)->status !== 'paid')
                    <a href="{{ route('payments.create', ['order_id' => $order->id]) }}" class="btn btn-brand-primary">Process Payment</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid var(--brand-primary);">
                    <div class="card-header bg-brand-primary-10">
                        <strong class="text-brand-dark">Order Information</strong>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt class="fw-semibold text-brand-dark">Order #:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $order->order_number }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Customer:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $order->customer_name }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Phone:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $order->customer_phone ?: 'N/A' }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Address:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ $order->customer_address ?: 'N/A' }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Status:</dt>
                            <dd class="ms-3"><span class="badge badge-brand-primary p-2">{{ ucfirst($order->status) }}</span></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm" style="border-left: 4px solid var(--brand-accent);">
                    <div class="card-header bg-brand-accent-10">
                        <strong class="text-brand-dark">Payment Summary</strong>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt class="fw-semibold text-brand-dark">Total Amount:</dt>
                            <dd class="ms-3 text-brand-accent fw-semibold fs-5">₱{{ number_format($order->total_amount, 2) }}</dd>
                            <dt class="fw-semibold text-brand-dark mt-2">Payment Status:</dt>
                            <dd class="ms-3 text-brand-secondary">{{ optional($order->payment)->status ? ucfirst(optional($order->payment)->status) : 'Unpaid' }}</dd>
                            @if($order->payment)
                                <dt class="fw-semibold text-brand-dark mt-2">Paid At:</dt>
                                <dd class="ms-3 text-brand-secondary">{{ $order->payment->paid_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-brand-light mb-4">
            <div class="card-header bg-brand-light-20">
                <strong class="text-brand-dark">Order Items</strong>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($order->orderItems as $item)
                        <div class="list-group-item">
                            <div class="fw-semibold text-brand-dark">{{ $item->riceItem?->name ?? 'Unknown rice item' }}</div>
                            <div class="text-brand-secondary small mt-1">Quantity: {{ number_format($item->quantity_kg, 2) }} kg @ ₱{{ number_format($item->price_per_kg, 2) }}/kg</div>
                            <div class="fw-semibold text-brand-accent small mt-1">Subtotal: ₱{{ number_format($item->subtotal, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if($order->payment)
            <div class="card shadow-sm" style="border-left: 4px solid var(--brand-accent);">
                <div class="card-header bg-brand-accent-10">
                    <strong class="text-brand-dark">Last Payment</strong>
                </div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt class="fw-semibold text-brand-dark">Payment #:</dt>
                        <dd class="ms-3 text-brand-secondary">{{ $order->payment->payment_number }}</dd>
                        <dt class="fw-semibold text-brand-dark mt-2">Amount Paid:</dt>
                        <dd class="ms-3 text-brand-accent fw-semibold">₱{{ number_format($order->payment->amount_paid, 2) }}</dd>
                        <dt class="fw-semibold text-brand-dark mt-2">Change:</dt>
                        <dd class="ms-3 text-brand-secondary">₱{{ number_format($order->payment->change_amount, 2) }}</dd>
                        <dt class="fw-semibold text-brand-dark mt-2">Method:</dt>
                        <dd class="ms-3 text-brand-secondary">{{ $order->payment->getPaymentMethodLabel() }}</dd>
                    </dl>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
