@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-muted">Here's what's happening with your BarBQ experience.</p>
                </div>
                <a href="{{ route('menu') }}" class="btn btn-bbq-primary rounded-pill px-4">Order Now</a>
            </div>

            <!-- Quick Stats -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-bag-heart text-bbq-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h4>
                            <div class="text-muted small">Total Orders</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-calendar-check text-success fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $stats['active_reservations'] }}</h4>
                            <div class="text-muted small">Active Bookings</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-chat-heart text-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $stats['total_feedback'] }}</h4>
                            <div class="text-muted small">Feedbacks Shared</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Orders -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">Recent Orders</h6>
                            <a href="{{ route('customer.orders.index') }}"
                                class="text-bbq-primary small text-decoration-none">History <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold">#BarBQ-{{ $order->id }}</div>
                                                    <div class="text-muted tiny">{{ $order->created_at->format('M d, Y') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-bold">Rs. {{ number_format($order->total_amount) }}</span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    @include('components.status-badge', ['status' => $order->status])
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">Hungry? Place your first
                                                    order!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">Upcoming Tables</h6>
                            <a href="{{ route('customer.reservations.index') }}"
                                class="text-bbq-primary small text-decoration-none">Manage</a>
                        </div>
                        <div class="card-body p-4">
                            @forelse($upcomingReservations as $res)
                                <div class="d-flex align-items-center mb-4 pb-4 border-bottom last-border-0">
                                    <div class="bg-bbq-surface text-white rounded-3 p-2 text-center me-3" style="width: 50px;">
                                        <div class="tiny fw-bold">
                                            {{ \Carbon\Carbon::parse($res->reservation_date)->format('M') }}
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            {{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($res->reservation_time)->format('h:i A') }}
                                        </div>
                                        <div class="text-muted small">{{ $res->guests }} People</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-x mb-2 d-block fs-1 opacity-25"></i>
                                    No upcoming bookings.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations Banner -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-9 offset-md-3">
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <img src="{{ asset('images/special-offers.jpg') }}" class="img-fluid w-100" alt="Special Offers For You">
            </div>
        </div>
    </div>

    <style>
        .tiny {
            font-size: 0.7rem;
        }

        .last-border-0:last-child {
            border-bottom: none !important;
        }
    </style>
@endsection