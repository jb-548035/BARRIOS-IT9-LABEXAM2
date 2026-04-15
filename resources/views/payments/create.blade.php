<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Process Payment') }}</h2>
            <a href="{{ route('payments.index') }}" class="btn btn-brand-secondary">Back to Payments</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        <div class="card shadow-sm border-brand-light">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <strong>Errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('payments.store') }}" method="POST" id="payment-form">
                    @csrf

                    <div class="mb-3">
                        <label for="order-select" class="form-label fw-semibold text-brand-dark">Order</label>
                        <select name="order_id" id="order-select" class="form-select" required>
                            <option value="">Choose an order to pay</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" data-total="{{ $order->total_amount }}" {{ optional($selectedOrder)->id === $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }} — {{ $order->customer_name }} — ₱{{ number_format($order->total_amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="amount-due" class="form-label fw-semibold text-brand-dark">Amount Due</label>
                            <div class="form-control bg-brand-light-10 text-brand-dark fw-medium" id="amount-due">₱0.00</div>
                        </div>
                        <div class="col-md-6">
                            <label for="amount-paid" class="form-label fw-semibold text-brand-dark">Amount Paid</label>
                            <input type="number" name="amount_paid" id="amount-paid" step="0.01" min="0" value="{{ old('amount_paid', optional($selectedOrder)->total_amount ?? 0) }}" class="form-control" required>
                            <div class="invalid-feedback" id="amount-paid-error">
                                Amount paid cannot be less than the amount due.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="change-amount" class="form-label fw-semibold text-brand-dark">Change</label>
                        <div class="form-control bg-brand-accent-10 text-brand-accent fw-semibold" id="change-amount">₱0.00</div>
                    </div>

                    <div class="mb-3">
                        <label for="payment-method" class="form-label fw-semibold text-brand-dark">Payment Method</label>
                        <select id="payment-method" name="payment_method" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="reference-number" class="form-label fw-semibold text-brand-dark">Reference Number</label>
                        <input type="text" id="reference-number" name="reference_number" value="{{ old('reference_number') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold text-brand-dark">Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-brand-primary">Record Payment</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const orderSelect = document.getElementById('order-select');
        const amountDue = document.getElementById('amount-due');
        const amountPaidInput = document.getElementById('amount-paid');
        const changeAmount = document.getElementById('change-amount');
        const submitButton = document.querySelector('button[type="submit"]');

        function refreshPaymentSummary() {
            const selected = orderSelect.options[orderSelect.selectedIndex];
            const due = Number(selected.dataset.total || 0);
            const paid = Number(amountPaidInput.value || 0);
            const change = Math.max(0, paid - due);

            amountDue.textContent = `₱${due.toFixed(2)}`;
            changeAmount.textContent = `₱${change.toFixed(2)}`;

            // Validate amount paid
            validateAmountPaid(due, paid);
        }

        function validateAmountPaid(due, paid) {
            const isValid = paid >= due;
            amountPaidInput.classList.toggle('is-invalid', !isValid);
            submitButton.disabled = !isValid;
        }

        orderSelect.addEventListener('change', refreshPaymentSummary);
        amountPaidInput.addEventListener('input', function() {
            const selected = orderSelect.options[orderSelect.selectedIndex];
            const due = Number(selected.dataset.total || 0);
            const paid = Number(this.value || 0);
            validateAmountPaid(due, paid);
            refreshPaymentSummary();
        });

        refreshPaymentSummary();
    </script>
</x-app-layout>
