<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">
                {{ __('Rice Product Details') }}
            </h2>
            <div>
                <a href="{{ route('menu.edit', $riceItem) }}" class="btn btn-brand-primary me-2">
                    Edit
                </a>
                <a href="{{ route('menu.index') }}" class="btn btn-brand-secondary">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-lg py-4">

        <!-- Rice Name -->
        <div class="card shadow-sm mb-3 border-brand-light">
            <div class="card-body">
                <h3 class="fw-semibold text-brand-dark mb-1">
                    {{ $riceItem->name }}
                </h3>
                <small class="text-muted">Rice Name</small>
            </div>
        </div>

        <!-- Description -->
        <div class="card shadow-sm mb-4 border-brand-light">
            <div class="card-body">
                <p class="mb-1 text-muted">
                    {{ $riceItem->description ?: 'No description provided.' }}
                </p>
                <small class="text-muted">Description</small>
            </div>
        </div>

        <!-- Price & Stock -->
        <div class="row g-3 mb-4">

            <!-- Price -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0" style="border-left: 5px solid var(--brand-accent);">
                    <div class="card-body">
                        <small class="text-muted">Price per Kilogram</small>
                        <div class="h5 fw-bold text-brand-accent mt-1">
                            ₱{{ number_format($riceItem->price_per_kg, 2) }} / kg
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0" style="border-left: 5px solid var(--brand-light);">
                    <div class="card-body">
                        <small class="text-muted">Stock Quantity</small>
                        <div class="h5 fw-bold text-brand-dark mt-1">
                            {{ number_format($riceItem->stock_quantity, 2) }} kg
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Availability -->
        <div class="card shadow-sm border-brand-light">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <strong class="text-brand-dark">Availability</strong>
                </div>
                <span class="badge px-3 py-2 {{ $riceItem->is_available ? 'badge-brand-accent' : 'badge-brand-secondary' }}">
                    {{ $riceItem->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>
        </div>

    </div>
</x-app-layout>