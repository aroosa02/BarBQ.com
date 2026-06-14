@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Categories</h3>
        <p class="text-muted">Manage food categories for your menu.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
        <i class="bi bi-plus-lg"></i> Add Category
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
                        <th class="py-3">Description</th>
                        <th class="py-3">Items</th>
                        <th class="py-3 text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-4">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/placeholders/category-placeholder.jpg') }}" 
                                 alt="{{ $category->name }}" 
                                 class="rounded-3 shadow-sm" 
                                 style="width: 60px; hieght: 45px; object-fit: cover;">
                        </td>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td class="text-muted small">{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $category->menuItems->count() }} Items</span>
                        </td>
                        <td class="text-end px-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? All related menu items will be deleted.')">
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
                            <i class="bi bi-folder2-open display-4 mb-3 d-block"></i>
                            No categories found. Start by adding one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
