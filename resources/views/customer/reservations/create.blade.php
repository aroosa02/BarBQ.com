@extends('layouts.app')

@section('title', 'Book a Table')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="mb-4">
                <a href="{{ route('customer.reservations.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> My Reservations
                </a>
                <h3 class="fw-bold mt-2">Book a Table</h3>
                <p class="text-muted">Fill in the details to reserve your spot at BarBQ Smokehouse.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('customer.reservations.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reservation_date" class="form-label fw-bold">Select Date</label>
                                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror"
                                        id="reservation_date" name="reservation_date"
                                        value="{{ old('reservation_date', date('Y-m-d')) }}" required
                                        min="{{ date('Y-m-d') }}">
                                    @error('reservation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reservation_time" class="form-label fw-bold">Select Time</label>
                                    <input type="time" class="form-control @error('reservation_time') is-invalid @enderror"
                                        id="reservation_time" name="reservation_time"
                                        value="{{ old('reservation_time', '19:00') }}" required>
                                    @error('reservation_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="guests" class="form-label fw-bold">Number of Guests</label>
                                    <div class="btn-group w-100" role="group">
                                        @foreach([1, 2, 3, 4, 5, 8, 10] as $g)
                                            <input type="radio" class="btn-check" name="guests" id="guest{{ $g }}"
                                                value="{{ $g }}" {{ old('guests', 2) == $g ? 'checked' : '' }}>
                                            <label class="btn btn-outline-bbq-primary"
                                                for="guest{{ $g }}">{{ $g == 10 ? '10+' : $g }}</label>
                                        @endforeach
                                    </div>
                                    <div class="form-text mt-2">For large events (+20 people), please call us directly.
                                    </div>
                                    @error('guests')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid shadow-sm">
                                    <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill py-3">Confirm
                                        Reservation Request</button>
                                </div>
                                <p class="text-center text-muted small mt-3">
                                    <i class="bi bi-info-circle me-1"></i> Reservations are subject to availability and
                                    manager approval.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection