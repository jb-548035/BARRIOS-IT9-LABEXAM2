<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Create Order') }}</h2>
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

                        <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                            @csrf

                            <div class="mb-3">
                                <label for="meal-select" class="form-label fw-semibold text-brand-dark">Rice Item</label>
                                <select name="menu_id" id="meal-select" class="form-select" required>
                                    <option value="">Select rice item</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}" data-price="{{ $menu->price_per_kg }}" data-stock="{{ $menu->stock_quantity }}">{{ $menu->name }} — ₱{{ number_format($menu->price_per_kg, 2) }} | {{ number_format($menu->stock_quantity, 2) }} kg</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label fw-semibold text-brand-dark">Quantity (kg)</label>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', '1') }}" step="0.01" min="0.01" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-brand-dark">Unit Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-brand-light-20">₱</span>
                                            <input type="text" id="unit-price" class="form-control bg-brand-light-10" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-brand-dark">Total Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-brand-accent-20 text-brand-accent fw-bold">₱</span>
                                    <input type="text" id="order-total" class="form-control fw-bold" style="color: var(--brand-accent);" readonly>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-3">
                                <label for="customer_name" class="form-label fw-semibold text-brand-dark">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label fw-semibold text-brand-dark">Phone</label>
                                        <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_address" class="form-label fw-semibold text-brand-dark">Address</label>
                                        <input type="text" name="customer_address" id="customer_address" value="{{ old('customer_address') }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label fw-semibold text-brand-dark">Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-brand-primary">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const mealSelect = document.getElementById('meal-select');
        const quantityInput = document.getElementById('quantity');
        const unitPrice = document.getElementById('unit-price');
        const orderTotal = document.getElementById('order-total');

        function updatePrices() {
            const selected = mealSelect.options[mealSelect.selectedIndex];
            const price = Number(selected.dataset.price || 0);
            const qty = Number(quantityInput.value || 0);
            const total = price * qty;

            unitPrice.value = price.toFixed(2);
            orderTotal.value = total.toFixed(2);
        }

        mealSelect.addEventListener('change', updatePrices);
        quantityInput.addEventListener('input', updatePrices);
        updatePrices();
    </script>
</x-app-layout>
