@extends('layouts.app')

@section('title', 'BarBQ Excellence')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-11">
            <!-- Hero Section -->
            <div class="card p-0 mb-5 shadow rounded-4 border-0 position-relative overflow-hidden"
                style="min-height: 400px; background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Overlay for readability -->
                <div class="position-absolute top-0 start-0 w-100 h-100"
                    style="background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%); z-index: 1;"></div>

                <div class="card-body p-5 position-relative" style="z-index: 2;">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-7 text-center text-lg-start text-white">
                            <h1 class="display-3 fw-bold mb-3">Savor the Smoke.</h1>
                            <p class="lead mb-4 opacity-90">Discover the most premium BarBQ experience. Traditional
                                slow-cooked meats, secret spice blends, and the perfect sear.</p>
                            <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                                <a href="{{ route('menu') }}"
                                    class="btn btn-bbq-pink btn-lg px-5 rounded-pill shadow">Browse Menu</a>
                                <a href="{{ route('customer.reservations.create') }}"
                                    class="btn btn-outline-light btn-lg px-5 rounded-pill">Reserve Table</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Offers Banner -->
            <section class="mb-5 animate-fade-in position-relative">
                <div class="position-absolute top-0 start-0 m-4" style="z-index: 10;">
                    <span class="badge bg-bbq-pink rounded-pill px-4 py-2 shadow-sm fs-6">HOT DEAL <i class="bi bi-fire"></i></span>
                </div>
                <div class="card border-0 shadow rounded-5 overflow-hidden">
                    <img src="{{ asset('images/special-offers.jpg') }}" class="img-fluid w-100" alt="Special BarBQ Platter Offers">
                </div>
            </section>

            <!-- Categories -->
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h2 class="fw-bold mb-0">Our Categories</h2>
                    <a href="{{ route('menu') }}" class="text-bbq-primary fw-bold text-decoration-none">View All Menu <i
                            class="bi bi-arrow-right"></i></a>
                </div>
                <div class="row g-4">
                    @forelse($categories as $category)
                        <div class="col-md-3">
                            <a href="{{ route('menu', ['category' => $category->id]) }}" class="text-decoration-none text-dark">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card transition">
                                    <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/placeholders/category-placeholder.jpg') }}"
                                        class="card-img-top" alt="{{ $category->name }}"
                                        style="height: 180px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title fw-bold mb-1">{{ $category->name }}</h5>
                                        <p class="text-muted small mb-0">{{ $category->menu_items_count }} Items</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center col-12">No categories defined yet.</p>
                    @endforelse
                </div>
            </section>

            <!-- Featured Deals -->
            @if($deals->count() > 0)
                <section class="mb-5 bg-bbq-surface p-5 rounded-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold">Exclusive Deals</h2>
                        <p class="text-muted">Perfect for families and group hangouts.</p>
                    </div>
                    <div class="row g-4">
                        @foreach($deals as $deal)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow rounded-4 overflow-hidden">
                                    <div class="position-relative">
                                        <img src="{{ $deal->image ? asset('storage/' . $deal->image) : asset('images/placeholders/deal-placeholder.jpg') }}"
                                            class="card-img-top" alt="{{ $deal->name }}" style="height: 220px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-bbq-primary rounded-pill px-3 py-2 shadow">Rs.
                                                {{ number_format($deal->price) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 text-center">
                                        <h4 class="fw-bold mb-3">{{ $deal->name }}</h4>
                                        <p class="text-muted small mb-4">{{ $deal->description }}</p>
                                        <a href="{{ route('customer.orders.create', ['deal_id' => $deal->id]) }}"
                                            class="btn btn-bbq-primary w-100 rounded-pill py-2">Add to Order</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- About & Contact Section -->
            <section class="mt-5 pt-5 border-top">
                <div class="row g-5">
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-4">Our Heritage</h2>
                        <p class="text-muted lead">Founded in 1998, BarBQ Smokehouse has been the cornerstone of authentic
                            pit-smoking in the city. We believe in high-quality wood, patient slow-cooking, and a spice
                            blend that has been passed down through generations.</p>
                        <div class="row mt-4">
                            <div class="col-6">
                                <h4 class="fw-bold text-bbq-primary mb-1">100%</h4>
                                <p class="small text-muted">Organic Wood Fired</p>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-bold text-bbq-primary mb-1">12h</h4>
                                <p class="small text-muted">Slow Smoked Meat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow rounded-4 bg-white p-4">
                            <h4 class="fw-bold mb-4">Find Us</h4>
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-light p-3 me-3"><i
                                        class="bi bi-geo-alt text-bbq-primary fs-5"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-0">Location</h6>
                                    <p class="text-muted small mb-0">123 Smokee Lane, Grill District, RawalPindi</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-light p-3 me-3"><i
                                        class="bi bi-telephone text-bbq-primary fs-5"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-0">Reservations</h6>
                                    <p class="text-muted small mb-0">+92 316 505 5030 </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light p-3 me-3"><i
                                        class="bi bi-clock text-bbq-primary fs-5"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-0">Open Hours</h6>
                                    <p class="text-muted small mb-0">Mon - Sun: 5:00 PM - 12:00 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .transition {
            transition: all 0.3s ease;
        }

        .tiny {
            font-size: 0.75rem;
        }
    </style>
@endsection