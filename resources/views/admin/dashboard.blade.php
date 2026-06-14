@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <div class="row g-4 mb-5">
        <!-- Revenue Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-bbq-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-uppercase small opacity-75 fw-bold">Total Revenue</h6>
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0">Rs. {{ number_format($stats['total_revenue']) }}</h3>
                    <div class="small mt-2"><i class="bi bi-arrow-up"></i> Lifetime Earnings</div>
                </div>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 border-start border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                        <h6 class="mb-0 text-uppercase small fw-bold">Total Expenses</h6>
                        <i class="bi bi-cart-x fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0">Rs. {{ number_format($stats['total_expenses']) }}</h3>
                    <div class="small mt-2 text-danger"><i class="bi bi-wallet2"></i> Operational Costs</div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                        <h6 class="mb-0 text-uppercase small fw-bold">Active Orders</h6>
                        <i class="bi bi-fire fs-4"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-warning">{{ $stats['active_orders'] }}</h2>
                    <div class="small mt-2"><i class="bi bi-clock"></i> Preparing / Ready</div>
                </div>
            </div>
        </div>

        <!-- Reservations Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                        <h6 class="mb-0 text-uppercase small fw-bold">Pend. Bookings</h6>
                        <i class="bi bi-calendar-event fs-4"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-success">{{ $stats['pending_reservations'] }}</h2>
                    <div class="small mt-2 text-success"><i class="bi bi-check-all"></i> Tables Requested</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light rounded-pill">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 border-0">Order</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0 text-end px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="px-4 fw-bold">#{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td class="fw-bold text-bbq-primary">Rs. {{ number_format($order->total_amount) }}</td>
                                        <td class="text-end px-4">
                                            @include('components.status-badge', ['status' => $order->status])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No recent orders.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Revenue by Category</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($revenueByCategory as $rev)
                            <div class="list-group-item px-0 border-0 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">{{ $rev->name }}</span>
                                    <span class="text-bbq-primary fw-bold">Rs. {{ number_format($rev->total) }}</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 6px;">
                                    @php 
                                        $perc = $stats['total_revenue'] > 0 ? ($rev->total / $stats['total_revenue']) * 100 : 0;
                                    @endphp
                                    <div class="progress-bar bg-bbq-primary" role="progressbar" style="width: {{ $perc }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Stats -->
        <div class="col-md-12">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="p-4 bg-white shadow-sm rounded-4 d-flex align-items-center">
                        <div class="rounded-circle bg-light p-3 me-3"><i class="bi bi-people text-primary"></i></div>
                        <div>
                            <div class="text-muted small">Total Customers</div>
                            <h5 class="fw-bold mb-0">{{ $stats['total_users'] }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white shadow-sm rounded-4 d-flex align-items-center">
                        <div class="rounded-circle bg-light p-3 me-3"><i class="bi bi-book text-success"></i></div>
                        <div>
                            <div class="text-muted small">Menu Items</div>
                            <h5 class="fw-bold mb-0">{{ $stats['menu_items'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection