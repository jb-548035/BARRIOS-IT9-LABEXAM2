<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Add Rice Product') }}</h2>
            <a href="{{ route('menu.index') }}" class="btn btn-brand-secondary">Back to Menu</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
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

                        <form action="{{ route('menu.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-brand-dark">Rice Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price_per_kg" class="form-label fw-semibold text-brand-dark">Price per kg</label>
                                        <input type="number" name="price_per_kg" id="price_per_kg" step="0.01" value="{{ old('price_per_kg') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label fw-semibold text-brand-dark">Stock Quantity (kg)</label>
                                        <input type="number" name="stock_quantity" id="stock_quantity" step="0.01" value="{{ old('stock_quantity') }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-brand-dark">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_available" id="is_available" value="1" class="form-check-input" {{ old('is_available') ? 'checked' : '' }}>
                                <label class="form-check-label text-brand-dark" for="is_available">
                                    Available for sale
                                </label>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-brand-primary">Save Rice Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
