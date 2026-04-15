<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Edit Order') }}</h2>
            <a href="{{ route('orders.index') }}" class="btn btn-brand-secondary">Back to Orders</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-brand-secondary mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label fw-semibold text-brand-dark">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_phone" class="form-label fw-semibold text-brand-dark">Phone</label>
                                    <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="form-label fw-semibold text-brand-dark">Address</label>
                                <textarea name="customer_address" id="customer_address" rows="2" class="form-control">{{ old('customer_address', $order->customer_address) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold text-brand-dark">Order Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold text-brand-dark">Order Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $statusOption)
                                            <option value="{{ $statusOption }}" {{ old('status', $order->status) === $statusOption ? 'selected' : '' }}>{{ ucfirst($statusOption) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-brand-dark">Total Amount</label>
                                    <div class="form-control bg-brand-light-10 text-brand-accent fw-bold">₱{{ number_format($order->total_amount, 2) }}</div>
                                </div>
                            </div>

                            <div class="card border-brand-light bg-brand-light-5 mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-brand-dark mb-3">Order Items</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-brand-dark fw-semibold">Item</th>
                                                    <th class="text-brand-dark fw-semibold text-center">Quantity</th>
                                                    <th class="text-brand-dark fw-semibold text-center">Price/kg</th>
                                                    <th class="text-brand-dark fw-semibold text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderItems as $item)
                                                    <tr>
                                                        <td class="text-brand-dark">{{ $item->riceItem?->name ?? 'Unknown item' }}</td>
                                                        <td class="text-center text-brand-secondary">{{ number_format($item->quantity_kg, 2) }} kg</td>
                                                        <td class="text-center text-brand-secondary">₱{{ number_format($item->price_per_kg, 2) }}</td>
                                                        <td class="text-end text-brand-accent fw-bold">₱{{ number_format($item->subtotal, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-brand-primary">Update Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
