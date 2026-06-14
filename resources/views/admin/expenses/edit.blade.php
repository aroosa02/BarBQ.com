@extends('layouts.admin')

@section('title', 'Edit Expense')

@section('admin-content')
    <div class="mb-4">
        <a href="{{ route('admin.expenses.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Expenses
        </a>
        <h3 class="fw-bold mt-2">Edit Expense Record</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Expense Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $expense->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category"
                                name="category" required>
                                @foreach(['Raw Materials', 'Utilities', 'Salaries', 'Maintenance', 'Marketing', 'Other'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $expense->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold">Amount (Rs.)</label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expense_date" class="form-label fw-bold">Expense Date</label>
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror"
                                id="expense_date" name="expense_date"
                                value="{{ old('expense_date', $expense->expense_date) }}" required>
                            @error('expense_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="5">{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill">Update Expense
                                Record</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection