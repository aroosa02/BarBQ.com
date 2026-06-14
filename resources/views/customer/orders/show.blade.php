@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="row pt-5 justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('customer.orders.index') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left"></i> My Orders
                    </a>
                    <h3 class="fw-bold mt-2">Order #BarBQ-{{ $order->id }}</h3>
                </div>
                <div class="text-end">
                    @include('components.status-badge', ['status' => $order->status])
                    <div class="text-muted small mt-2">Placed on {{ $order->created_at->format('M d, Y at h:i A') }}</div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h6 class="mb-0 fw-bold">Items in Order</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4 py-3">Item</th>
                                            <th class="py-3">Price</th>
                                            <th class="py-3">Qty</th>
                                            <th class="py-3 text-end px-4">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td class="px-4">
                                                    <div class="d-flex align-items-center">
                                                        @if($item->menuItem)
                                                            <img src="{{ $item->menuItem->image ? asset('storage/' . $item->menuItem->image) : asset('images/placeholders/menu-placeholder.jpg') }}"
                                                                class="rounded-3 shadow-sm me-3"
                                                                style="width: 45px; height: 45px; object-fit: cover;">
                                                            <div class="fw-bold">{{ $item->menuItem->name }}</div>
                                                        @else
                                                            <img src="{{ $item->deal->image ? asset('storage/' . $item->deal->image) : asset('images/placeholders/deal-placeholder.jpg') }}"
                                                                class="rounded-3 shadow-sm me-3"
                                                                style="width: 45px; height: 45px; object-fit: cover;">
                                                            <div class="fw-bold">{{ $item->deal->name }}</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>Rs. {{ number_format($item->price) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="text-end px-4 fw-bold text-bbq-primary">Rs.
                                                    {{ number_format($item->price * $item->quantity) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-4 border-0">
                            <div class="row justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total Amount</span>
                                        <h4 class="fw-bold text-bbq-primary mb-0">Rs.
                                            {{ number_format($order->total_amount) }}
                                        </h4>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Payment status</span>
                                        <span
                                            class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-bbq-surface text-white p-4 mb-4">
                        <h5 class="fw-bold mb-4">Service Details</h5>
                        <div class="mb-3">
                            <label class="opacity-75 small text-uppercase">Order Type</label>
                            <div class="fw-bold fs-5">{{ ucfirst($order->type) }}</div>
                        </div>
                        @if($order->type === 'dine-in')
                            <div class="mb-3">
                                <label class="opacity-75 small text-uppercase">Table Number</label>
                                <div class="fw-bold fs-5">{{ $order->table_number }}</div>
                            </div>
                        @endif
                        <div class="mb-0">
                            <label class="opacity-75 small text-uppercase">Payment Mode</label>
                            <div class="fw-bold fs-5 text-capitalize">{{ $order->payment_method ?? 'Cash on Counter' }}
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                        <h5 class="fw-bold mb-3">Kitchen Status</h5>
                        <div class="py-3">
                            @if($order->status === 'pending')
                                <i class="bi bi-clock-history display-4 text-warning mb-3 d-block"></i>
                                <p class="mb-0">Waiting for kitchen to accept your order...</p>
                            @elseif($order->status === 'preparing')
                                <div class="spinner-border text-bbq-primary mb-3" style="width: 3rem; height: 3rem;"
                                    role="status"></div>
                                <p class="mb-0">Chef is preparing your delicious meal!</p>
                            @elseif($order->status === 'ready')
                                <i class="bi bi-bell-fill display-4 text-success mb-3 d-block animate-bounce"></i>
                                <p class="mb-0 fw-bold">Your order is READY!</p>
                            @elseif($order->status === 'completed')
                                <i class="bi bi-check-circle-fill display-4 text-success mb-3 d-block"></i>
                                <p class="mb-0">Thank you for dining with us!</p>
                            @else
                                <i class="bi bi-x-circle-fill display-4 text-danger mb-3 d-block"></i>
                                <p class="mb-0">This order was cancelled.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .animate-bounce {
            animation: bounce 2s infinite;
        }
    </style>
@endsection