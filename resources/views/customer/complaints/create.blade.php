@extends('layouts.app')

@section('title', 'Submit Feedback')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="mb-4">
                <a href="{{ route('customer.complaints.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Feedback
                </a>
                <h3 class="fw-bold mt-2">Submit Feedback</h3>
                <p class="text-muted">Tell us about your experience or report an issue.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('customer.complaints.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                                name="subject" value="{{ old('subject') }}" required
                                placeholder="e.g., Food Quality, Staff Service, App Error">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Your Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                name="message" rows="6" required
                                placeholder="Describe your experience in detail...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid shadow">
                            <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill py-3 fw-bold">Submit
                                Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection