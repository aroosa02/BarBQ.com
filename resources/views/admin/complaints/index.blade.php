@extends('layouts.admin')

@section('title', 'Customer Feedback')

@section('admin-content')
    <div class="mb-4">
        <h3 class="fw-bold">Customer Feedback</h3>
        <p class="text-muted">Review and resolve customer concerns and praise.</p>
    </div>

    <div class="row g-4">
        @forelse($complaints as $comp)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span
                                class="badge {{ $comp->status === 'resolved' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                {{ ucfirst($comp->status) }}
                            </span>
                            <small class="text-muted">{{ $comp->created_at->diffForHumans() }}</small>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $comp->subject }}</h5>
                        <div class="small fw-bold text-bbq-primary mb-3">From: {{ $comp->user->name }}</div>
                        <p class="text-muted small mb-4">{{ $comp->message }}</p>

                        @if($comp->status === 'pending')
                            <div class="d-grid shadow-sm">
                                <form action="{{ route('admin.complaints.resolve', $comp) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100 rounded-pill py-2">Mark as
                                        Resolved</button>
                                </form>
                            </div>
                        @else
                            <div class="text-center text-success small fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> Resolved
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-smile display-4 text-muted mb-3 d-block"></i>
                <p class="text-muted">No complaints filed yet. Great job!</p>
            </div>
        @endforelse
    </div>
@endsection