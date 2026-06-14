@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="row pt-5 justify-content-center">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">Complete Your Order</h3>

            <div class="row g-4">
                <!-- Order Summary -->
                <div class="col-md-5 order-md-last">
                    <div class="card border-0 shadow-sm rounded-4 bg-light overflow-hidden">
                        <div class="card-header bg-bbq-primary text-white py-3 border-0">
                            <h6 class="mb-0 fw-bold">Order Summary</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                @if($menuItem)
                                    <img src="{{ $menuItem->image ? asset('storage/' . $menuItem->image) : asset('images/placeholders/menu-placeholder.jpg') }}"
                                        class="rounded-3 shadow-sm me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $menuItem->name }}</h6>
                                        <small class="text-muted">{{ $menuItem->category->name }}</small>
                                    </div>
                                @else
                                    <img src="{{ $deal->image ? asset('storage/' . $deal->image) : asset('images/placeholders/deal-placeholder.jpg') }}"
                                        class="rounded-3 shadow-sm me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $deal->name }}</h6>
                                        <small class="text-muted">Promotion Deal</small>
                                    </div>
                                @endif
                            </div>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Item Price</span>
                                    <span class="fw-bold">Rs.
                                        {{ number_format($menuItem ? $menuItem->price : $deal->price) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Quantity</span>
                                    <span class="fw-bold" id="summaryQty">1</span>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-3 pt-3">
                                    <h5 class="fw-bold fs-4">Total Amount</h5>
                                    <h5 class="fw-bold text-bbq-primary fs-4" id="summaryTotal">Rs.
                                        {{ number_format($menuItem ? $menuItem->price : $deal->price) }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <form action="{{ route('customer.orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $menuItem->id ?? '' }}">
                                <input type="hidden" name="deal_id" value="{{ $deal->id ?? '' }}">

                                <h5 class="fw-bold mb-4">Delivery & Options</h5>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Quantity</label>
                                    <input type="number" name="quantity" id="orderQty"
                                        class="form-control form-control-lg text-center fw-bold" value="1" min="1"
                                        onchange="updateTotal()">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Order
                                        Type</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="type" id="typeDineIn"
                                                value="dine-in" checked onchange="toggleTable(true)">
                                            <label class="btn btn-outline-bbq-primary w-100 py-3 rounded-4"
                                                for="typeDineIn">
                                                <i class="bi bi-shop fs-4 d-block mb-1"></i> Dine-In
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="type" id="typeTakeaway"
                                                value="takeaway" onchange="toggleTable(false)">
                                            <label class="btn btn-outline-bbq-primary w-100 py-3 rounded-4"
                                                for="typeTakeaway">
                                                <i class="bi bi-box fs-4 d-block mb-1"></i> Takeaway
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="tableSection" class="mb-4">
                                    <label for="table_number"
                                        class="form-label fw-bold small text-muted text-uppercase mb-3">Select Table
                                        Number</label>
                                    <select name="table_number" id="table_number" class="form-select form-select-lg">
                                        <option value="">Choose Table...</option>
                                        @foreach(['T-1', 'T-2', 'T-3', 'T-4', 'VIP-1', 'VIP-2'] as $table)
                                            <option value="{{ $table }}">Table {{ $table }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Payment
                                        Method</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="payment_method" id="payCash"
                                                value="cash" checked>
                                            <label class="btn btn-outline-secondary w-100 py-2 rounded-3" for="payCash">
                                                <i class="bi bi-cash"></i> Cash
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="payment_method" id="payCard"
                                                value="card">
                                            <label class="btn btn-outline-secondary w-100 py-2 rounded-3" for="payCard">
                                                <i class="bi bi-credit-card"></i> Card/Online
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid shadow">
                                    <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill py-3 fw-bold">Confirm & Place Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const unitPrice = {{ $menuItem ? $menuItem->price : $deal->price }};

        function updateTotal() {
            const qty = document.getElementById('orderQty').value;
            const total = unitPrice * qty;
            document.getElementById('summaryQty').innerText = qty;
            document.getElementById('summaryTotal').innerText = 'Rs. ' + total.toLocaleString();
        }

        function toggleTable(show) {
            const section = document.getElementById('tableSection');
            const select = document.getElementById('table_number');
            if (show) {
                section.classList.remove('d-none');
                select.required = true;
            } else {
                section.classList.add('d-none');
                select.required = false;
            }
        }
    </script>
@endsection