@extends('layouts.admin')

@section('title', 'Manage Deals')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Promotional Deals</h3>
            <p class="text-muted">Bundles and special offers for your customers.</p>
        </div>
        <a href="{{ route('admin.deals.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
            <i class="bi bi-plus-lg"></i> Create New Deal
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Image</th>
                            <th class="py-3">Deal Name</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Includes</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deals as $deal)
                            <tr>
                                <td class="px-4">
                                    <img src="{{ $deal->image ? asset('storage/' . $deal->image) : asset('images/placeholders/deal-placeholder.jpg') }}"
                                        alt="{{ $deal->name }}" class="rounded-3 shadow-sm"
                                        style="width: 80px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $deal->name }}</div>
                                    <div class="text-muted small">{{ Str::limit($deal->description, 50) }}</div>
                                </td>
                                <td class="fw-bold text-bbq-primary">Rs. {{ number_format($deal->price, 2) }}</td>
                                <td>
                                    <div class="small">
                                        @foreach($deal->menuItems as $item)
                                            <div><i class="bi bi-check-circle-fill text-success tiny"></i>
                                                {{ $item->pivot->quantity }}x {{ $item->name }}</div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-end px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.deals.edit', $deal) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this deal?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-percent display-4 mb-3 d-block"></i>
                                    No deals active. Create a bundle now!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection