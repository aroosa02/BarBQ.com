@extends('layouts.admin')

@section('title', 'Expense Tracking')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Operational Expenses</h3>
            <p class="text-muted">Track overheads, salaries, and procurement costs.</p>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
            <i class="bi bi-plus-lg"></i> Record Expense
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $expense->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($expense->description, 40) }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $expense->category }}</span>
                                </td>
                                <td class="fw-bold text-danger">Rs. {{ number_format($expense->amount) }}</td>
                                <td class="text-end px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.expenses.edit', $expense) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
                                            onsubmit="return confirm('Delete this expense record?')">
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
                                    <i class="bi bi-receipt display-4 mb-3 d-block"></i>
                                    No expenses recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection