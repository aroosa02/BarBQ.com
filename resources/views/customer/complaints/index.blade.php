@extends('layouts.app')

@section('title', 'My Feedback')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">My Feedback & Complaints</h3>
                <a href="{{ route('customer.complaints.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
                    <i class="bi bi-chat-dots"></i> Submit Feedback
                </a>
            </div>

            @forelse($complaints as $complaint)
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $complaint->subject }}</h5>
                            <span
                                class="badge {{ $complaint->status === 'resolved' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                {{ ucfirst($complaint->status) }}
                            </span>
                        </div>
                        <p class="text-muted mb-3">{{ $complaint->message }}</p>
                        <div class="small text-muted">Submitted on {{ $complaint->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white shadow-sm rounded-4">
                    <i class="bi bi-chat-square-text display-4 text-muted mb-3 d-block"></i>
                    <p class="text-muted">You haven't submitted any feedback yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection