<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Orders') }}</h2>
            <a href="{{ route('orders.create') }}" class="btn btn-brand-primary">+ Create Order</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        @if(session('success'))
            <div class="alert alert-brand-accent mb-4">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-brand-dark fw-semibold">Order #</th>
                            <th scope="col" class="text-brand-dark fw-semibold">Customer</th>
                            <th scope="col" class="text-brand-dark fw-semibold">Items</th>
                            <th scope="col" class="text-brand-dark fw-semibold">Total</th>
                            <th scope="col" class="text-brand-dark fw-semibold">Status</th>
                            <th scope="col" class="text-brand-dark fw-semibold">Payment</th>
                            <th scope="col" class="text-brand-dark fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="text-brand-dark fw-semibold">{{ $order->order_number }}</td>
                                <td class="text-brand-dark">{{ $order->customer_name }}</td>
                                <td class="text-brand-secondary">{{ $order->orderItems->pluck('riceItem.name')->filter()->join(', ') }}</td>
                                <td class="text-brand-dark fw-bold">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="badge {{ $order->status === 'completed' ? 'badge-brand-accent' : ($order->status === 'cancelled' ? 'badge-brand-secondary' : 'badge-brand-primary') }}">{{ ucfirst($order->status) }}</span></td>
                                <td><span class="badge {{ optional($order->payment)->status === 'paid' ? 'badge-brand-accent' : (optional($order->payment)->status === 'partial' ? 'badge-brand-light' : 'badge-brand-secondary') }}">{{ optional($order->payment)->status ? ucfirst(optional($order->payment)->status) : 'Unpaid' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary text-brand-primary me-2">View</a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-info text-brand-accent me-2">Edit</a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger text-brand-secondary" onclick="return confirm('Delete this order?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No orders have been placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
