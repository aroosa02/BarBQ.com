@extends('layouts.admin')

@section('title', 'Kitchen Display System')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Active Orders (KDS)</h3>
            <p class="text-muted">Manage the kitchen workflow and payment status.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="window.location.reload()"><i
                    class="bi bi-arrow-clockwise"></i> Refresh</button>
        </div>
    </div>

    <div class="row g-4">
        @forelse($orders as $order)
            <div class="col-md-6 col-xl-4">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 {{ $order->status === 'ready' ? 'border-start border-4 border-success' : ($order->status === 'preparing' ? 'border-start border-4 border-bbq-primary' : '') }}">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">#BarBQ-{{ $order->id }}</h6>
                        <span
                            class="badge bg-light text-dark border">{{ $order->type === 'dine-in' ? 'Table ' . $order->table_number : 'Takeaway' }}</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <div class="small fw-bold text-muted mb-2">CUSTOMER</div>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-bbq-surface text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div class="small fw-bold">{{ $order->user->name }}</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small fw-bold text-muted mb-2">ITEMS</div>
                            <ul class="list-unstyled mb-0">
                                @foreach($order->orderItems as $item)
                                    <li class="small py-1 border-bottom d-flex justify-content-between">
                                        <span>
                                            <span class="fw-bold text-bbq-primary">{{ $item->quantity }}x</span>
                                            {{ $item->menuItem ? $item->menuItem->name : $item->deal->name }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <div class="small fw-bold text-muted mb-1">PREPARATION</div>
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing
                                        </option>
                                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="small fw-bold text-muted mb-1">PAYMENT</div>
                                <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="payment_status"
                                        class="form-select form-select-sm {{ $order->payment_status === 'paid' ? 'text-success fw-bold' : 'text-warning fw-bold' }}"
                                        onchange="this.form.submit()">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid
                                        </option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 py-2 d-flex justify-content-between align-items-center">
                        <span class="small text-muted">{{ $order->created_at->diffForHumans() }}</span>
                        <span class="fw-bold small">Total: Rs. {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-clock-history display-4 text-muted mb-3 d-block"></i>
                <p class="text-muted">No active orders in the kitchen.</p>
            </div>
        @endforelse
    </div>
@endsection