<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0">
        <div class="p-4 bg-bbq-primary text-white text-center">
            <div class="rounded-circle bg-white text-bbq-primary d-inline-flex align-items-center justify-content-center mb-3"
                style="width: 60px; height: 60px; font-size: 1.5rem;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h6 class="fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</h6>
            <small class="opacity-75">Customer Account</small>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('customer.dashboard') }}"
                class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('customer.dashboard') ? 'bg-light fw-bold text-bbq-primary border-start border-4 border-bbq-primary' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Overview
            </a>
            <a href="#" class="list-group-item list-group-item-action py-3 border-0">
                <i class="bi bi-bag-check me-2"></i> My Orders
            </a>
            <a href="{{ route('customer.reservations.index') }}"
                class="list-group-item list-group-item-action py-3 border-0 {{ request()->routeIs('customer.reservations.*') ? 'bg-light fw-bold text-bbq-primary border-start border-4 border-bbq-primary' : '' }}">
                <i class="bi bi-calendar-check me-2"></i> Reservations
            </a>
            <a href="#" class="list-group-item list-group-item-action py-3 border-0 text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>
    </div>
</div>