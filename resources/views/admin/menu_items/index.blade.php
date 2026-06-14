@extends('layouts.admin')

@section('title', 'Manage Menu Items')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Menu Items</h3>
            <p class="text-muted">Manage the dishes available in your restaurant.</p>
        </div>
        <a href="{{ route('admin.menu-items.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
            <i class="bi bi-plus-lg"></i> Add Menu Item
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Image</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menuItems as $item)
                            <tr>
                                <td class="px-4">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholders/menu-placeholder.jpg') }}"
                                        alt="{{ $item->name }}" class="rounded-3 shadow-sm"
                                        style="width: 60px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->name }}</div>
                                    <div class="text-muted small text-truncate" style="max-width: 200px;">
                                        {{ $item->description }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->category->name }}</span>
                                </td>
                                <td class="fw-bold text-bbq-primary">Rs. {{ number_format($item->price, 2) }}</td>
                                <td>
                                    @include('components.status-badge', ['status' => $item->status])
                                </td>
                                <td class="text-end px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.menu-items.edit', $item) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this item?')">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-egg-fried display-4 mb-3 d-block"></i>
                                    No menu items found. Add your first dish!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection