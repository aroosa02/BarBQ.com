@extends('layouts.admin')

@section('title', 'Edit Deal')

@section('admin-content')
    <div class="mb-4">
        <a href="{{ route('admin.deals.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Deals
        </a>
        <h3 class="fw-bold mt-2">Edit Deal: {{ $deal->name }}</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.deals.update', $deal) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Deal Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $deal->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label fw-bold">Deal Price (Rs.)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price', $deal->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3" required>{{ old('description', $deal->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Update Image</label>
                            @if($deal->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $deal->image) }}" alt="Current Image"
                                        class="rounded-3 shadow-sm" style="width: 150px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Modify Menu Items & Quantities</h5>
                        <div class="card bg-light border-0 p-3" style="max-height: 400px; overflow-y: auto;">
                            @foreach($menuItems as $item)
                                @php
                                    $isSelected = in_array($item->id, $selectedItems);
                                    $quantity = $selectedQuantities[$item->id] ?? 1;
                                @endphp
                                <div
                                    class="form-check mb-3 p-2 bg-white rounded shadow-sm border-start border-4 {{ $isSelected ? 'border-bbq-primary' : 'border-light' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="items[]"
                                                value="{{ $item->id }}" id="item{{ $item->id }}" {{ $isSelected ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="item{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                            <div class="text-muted small">Cat: {{ $item->category->name }}</div>
                                        </div>
                                        <div style="width: 80px;">
                                            <label class="small text-muted d-block text-center">Qty</label>
                                            <input type="number" name="quantities[{{ $item->id }}]" value="{{ $quantity }}"
                                                min="1" class="form-control form-control-sm text-center">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @error('items')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill">Update Deal
                                Bundle</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection