<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-brand-dark">{{ __('Rice Menu') }}</h2>
            <a href="{{ route('menu.create') }}" class="btn btn-brand-primary">+ Add Rice</a>
        </div>
    </x-slot>

    <div class="container-lg py-4">
        @if(session('success'))
            <div class="alert alert-brand-accent mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <p class="small text-muted mb-4">Manage rice products, prices, stock and availability in one place.</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-brand-dark fw-semibold">Name</th>
                                <th scope="col" class="text-brand-dark fw-semibold">Price / kg</th>
                                <th scope="col" class="text-brand-dark fw-semibold">Stock</th>
                                <th scope="col" class="text-brand-dark fw-semibold">Status</th>
                                <th scope="col" class="text-brand-dark fw-semibold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riceItems as $riceItem)
                                <tr>
                                    <td class="text-brand-dark fw-semibold">{{ $riceItem->name }}</td>
                                    <td class="text-brand-dark">₱{{ number_format($riceItem->price_per_kg, 2) }}</td>
                                    <td class="text-brand-dark">{{ number_format($riceItem->stock_quantity, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $riceItem->is_available ? 'badge-brand-accent' : 'badge-brand-secondary' }}">
                                            {{ $riceItem->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('menu.edit', $riceItem) }}" class="btn btn-sm btn-outline-primary text-brand-primary me-2">Edit</a>
                                        <a href="{{ route('menu.show', $riceItem) }}" class="btn btn-sm btn-outline-info text-brand-accent me-2">View</a>
                                        <form action="{{ route('menu.destroy', $riceItem) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger text-brand-secondary" onclick="return confirm('Delete this rice item?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No rice products found. Add a new one to get started.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>