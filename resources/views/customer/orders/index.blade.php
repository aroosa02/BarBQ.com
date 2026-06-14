@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <h3 class="fw-bold mb-4">My Orders</h3>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Order #</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Total</th>
                                    <th class="py-3">Order Status</th>
                                    <th class="py-3">Payment</th>
                                    <th class="py-3 text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="px-4 fw-bold">#BarBQ-{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="fw-bold text-bbq-primary">Rs. {{ number_format($order->total_amount) }}</td>
                                        <td>
                                            @include('components.status-badge', ['status' => $order->status])
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('customer.orders.show', $order) }}"
                                                class="btn btn-sm btn-light border rounded-pill px-3">View Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No orders found. Time to grab some
                                            BarBQ!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection