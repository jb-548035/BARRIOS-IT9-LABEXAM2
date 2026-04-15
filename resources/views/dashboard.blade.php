<x-app-layout>
    <x-slot name="header">
        <h2 class="h2 mb-0 text-brand-dark">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="container-lg py-4">
        <!-- Welcome Card -->
        <div class="card mb-4" style="background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-primary-light) 100%); border: none;">
            <div class="card-body text-white p-5">
                <h3 class="h4 mb-2 fw-bold">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="mb-0 opacity-90">{{ __('Manage your rice sales and orders efficiently') }}</p>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="row g-4 mb-5">
            <!-- Total Orders -->
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-2">Total Orders</p>
                                <p class="stat-value h3 mb-0">{{ \App\Models\Order::count() }}</p>
                            </div>
                            <div class="bg-brand-primary-10 rounded p-3">
                                <svg class="text-brand-primary" width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.24A1 1 0 005 4H3z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid var(--brand-accent);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-2">Completed Orders</p>
                                <p class="text-brand-accent h3 mb-0 fw-bold">{{ \App\Models\Order::where('status', 'completed')->count() }}</p>
                            </div>
                            <div class="bg-brand-accent-10 rounded p-3">
                                <svg class="text-brand-accent" width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid var(--brand-light);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-2">Total Revenue</p>
                                <p class="text-brand-dark h3 mb-0 fw-bold">₱{{ number_format(\App\Models\Order::sum('total_amount'), 2) }}</p>
                            </div>
                            <div class="bg-brand-light-10 rounded p-3">
                                <svg class="text-brand-accent" width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path d="M8.16 5.314l4.897-1.948A1 1 0 0115 4.3v4.816a6 6 0 01-3.75 5.541L8.5 15.141V5.314z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid var(--brand-secondary);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-2">Pending Orders</p>
                                <p class="text-brand-secondary h3 mb-0 fw-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="bg-brand-secondary-10 rounded p-3">
                                <svg class="text-brand-secondary" width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H4.75A3.25 3.25 0 001.5 4.75v10.5a3.25 3.25 0 003.25 3.25h10.5a3.25 3.25 0 003.25-3.25V9.5m-12-4h8m-8 3h5"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('menu.index') }}" class="card text-decoration-none h-100 shadow-sm transition-all" style="border-left: 4px solid var(--brand-primary);">
                    <div class="card-body">
                        <p class="fw-semibold text-brand-dark mb-2">Menu Items</p>
                        <p class="h4 text-brand-primary mb-0 fw-bold">{{ \App\Models\Rice::count() }}</p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('orders.index') }}" class="card text-decoration-none h-100 shadow-sm transition-all" style="border-left: 4px solid var(--brand-secondary);">
                    <div class="card-body">
                        <p class="fw-semibold text-brand-dark mb-2">Pending Orders</p>
                        <p class="h4 text-brand-secondary mb-0 fw-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('payments.index') }}" class="card text-decoration-none h-100 shadow-sm transition-all" style="border-left: 4px solid var(--brand-accent);">
                    <div class="card-body">
                        <p class="fw-semibold text-brand-dark mb-2">Payments</p>
                        <p class="h4 text-brand-accent mb-0 fw-bold">{{ \App\Models\Payment::count() }}</p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('menu.create') }}" class="card text-decoration-none h-100 shadow-sm transition-all btn-brand-primary" style="border: none;">
                    <div class="card-body text-white">
                        <p class="fw-semibold mb-2">Add Menu Item</p>
                        <p class="small mb-0 opacity-90">Create a new product</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
