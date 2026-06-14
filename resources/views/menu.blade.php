@extends('layouts.app')

@section('title', 'Menu - BarBQ Smokehouse')

@section('content')
    <div class="row py-5">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 100;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Filters</h5>

                    <form action="{{ route('menu') }}" method="GET">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-3">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Find a dish..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-3">Categories</label>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('menu') }}"
                                    class="btn {{ !request('category') ? 'btn-bbq-primary' : 'btn-outline-secondary' }} btn-sm rounded-pill text-start ps-3">
                                    All Categories
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('menu', ['category' => $category->id]) }}"
                                        class="btn {{ request('category') == $category->id ? 'btn-bbq-primary' : 'btn-outline-secondary' }} btn-sm rounded-pill text-start ps-3">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-bbq-primary rounded-pill">Apply Filters</button>
                            <a href="{{ route('menu') }}" class="btn btn-link text-muted small mt-2">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Menu Items Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">
                    @if(request('category'))
                        @foreach($categories as $cat)
                            @if($cat->id == request('category')) {{ $cat->name }} @endif
                        @endforeach
                    @elseif(request('search'))
                        Search Results for "{{ request('search') }}"
                    @else
                        Full Menu
                    @endif
                </h3>
                <span class="text-muted small">{{ $menuItems->total() }} items found</span>
            </div>

            <!-- Promotion Banner -->
            <div class="mb-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('images/special-offers.jpg') }}" class="img-fluid w-100" alt="Special Deals">
                </div>
            </div>

            @if($menuItems->count() > 0)
                <div class="row g-4">
                    @foreach($menuItems as $item)
                        <div class="col-md-6 col-xl-4">
                            <div
                                class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative menu-item-card transition">
                                <div class="position-relative">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholders/menu-placeholder.jpg') }}"
                                        class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                                    <span
                                        class="position-absolute top-0 start-0 m-3 badge bg-white text-dark shadow-sm">{{ $item->category->name }}</span>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="fw-bold mb-1">{{ $item->name }}</h5>
                                    <p class="text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                        {{ $item->description }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                        <span class="fw-bold text-bbq-primary fs-5">Rs. {{ number_format($item->price) }}</span>
                                        <a href="{{ route('customer.orders.create', ['item_id' => $item->id]) }}"
                                            class="btn btn-bbq-primary btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $menuItems->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5 bg-white shadow-sm rounded-4 mt-4">
                    <i class="bi bi-search display-1 text-muted mb-4 d-block"></i>
                    <h4 class="fw-bold">No dishes found</h4>
                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('menu') }}" class="btn btn-bbq-primary rounded-pill mt-3 px-5">View Full Menu</a>
                </div>
            @endif

            <!-- Special Deals Section (In Menu) -->
            @if($deals->count() > 0 && !request('category') && !request('search'))
                <div class="mt-5 pt-5 pb-4">
                    <h3 class="fw-bold mb-4">Combo Deals</h3>
                    <div class="row g-4">
                        @foreach($deals as $deal)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 bg-bbq-surface p-2 overflow-hidden">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-4">
                                            <img src="{{ $deal->image ? asset('storage/' . $deal->image) : asset('images/placeholders/deal-placeholder.jpg') }}"
                                                class="img-fluid rounded-4" alt="{{ $deal->name }}"
                                                style="height: 120px; width: 100%; object-fit: cover;">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body py-2 px-3">
                                                <h6 class="fw-bold mb-1">{{ $deal->name }}</h6>
                                                <p class="text-muted tiny mb-2">{{ Str::limit($deal->description, 50) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold text-bbq-primary">Rs.
                                                        {{ number_format($deal->price) }}</span>
                                                    <a href="{{ route('customer.orders.create', ['deal_id' => $deal->id]) }}"
                                                        class="btn btn-outline-bbq-primary btn-sm rounded-pill">View &
                                                        Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .menu-item-card:hover {
            transform: scale(1.02);
        }

        .tiny {
            font-size: 0.75rem;
        }
    </style>
@endsection