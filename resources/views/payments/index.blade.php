<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Payments') }}</h2>
            <a href="{{ route('payments.create') }}" class="btn btn-brand-primary">+ New Payment</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-brand-dark fw-semibold">Payment #</th>
                        <th class="text-brand-dark fw-semibold">Order</th>
                        <th class="text-brand-dark fw-semibold">Amount Paid</th>
                        <th class="text-brand-dark fw-semibold">Change</th>
                        <th class="text-brand-dark fw-semibold">Method</th>
                        <th class="text-brand-dark fw-semibold">Status</th>
                        <th class="text-brand-dark fw-semibold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="text-brand-dark fw-medium">{{ $payment->payment_number }}</td>
                            <td class="text-brand-dark">{{ $payment->order?->order_number ?? 'N/A' }}</td>
                            <td class="text-brand-dark fw-semibold">₱{{ number_format($payment->amount_paid, 2) }}</td>
                            <td class="text-brand-secondary">₱{{ number_format($payment->change_amount, 2) }}</td>
                            <td class="text-brand-dark">{{ $payment->getPaymentMethodLabel() }}</td>
                            <td>
                                <span class="badge {{ $payment->status === 'paid' ? 'badge-brand-accent' : ($payment->status === 'partial' ? 'badge-brand-light' : 'badge-brand-secondary') }} p-2">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-brand-primary me-1">Edit</a>
                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-brand-accent me-1">View</a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-brand-secondary" onclick="return confirm('Delete this payment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-brand-secondary py-4">No payment records yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
