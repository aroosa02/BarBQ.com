@extends('layouts.admin')

@section('title', 'Add Category')

@section('admin-content')
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
        <h3 class="fw-bold mt-2">Add New Category</h3>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required
                                placeholder="e.g., Starters, Main Course, Platters">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="4"
                                placeholder="Brief description of this category">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Category Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <div class="form-text">Recommended size: 800x600px. Max 2MB.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-light p-4">
                <h5 class="fw-bold">Tips</h5>
                <ul class="text-muted small">
                    <li>Use clear, short names for categories.</li>
                    <li>Add a description to help customers understand the variety.</li>
                    <li>High-quality images make your menu look more appetizing.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection