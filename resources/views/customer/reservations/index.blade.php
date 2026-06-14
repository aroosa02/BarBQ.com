@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">My Reservations</h3>
                <a href="{{ route('customer.reservations.create') }}" class="btn btn-bbq-primary rounded-pill px-4">
                    <i class="bi bi-calendar-plus"></i> Book Table
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="py-3">Time</th>
                                    <th class="py-3">Guests</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $res)
                                    <tr>
                                        <td class="px-4">
                                            <div class="fw-bold">
                                                {{ \Carbon\Carbon::parse($res->reservation_date)->format('M d, Y') }}</div>
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($res->created_at)->diffForHumans() }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($res->reservation_time)->format('h:i A') }}</td>
                                        <td>{{ $res->guests }} People</td>
                                        <td>
                                            @include('components.status-badge', ['status' => $res->status])
                                            @if($res->admin_note)
                                                <div class="tiny text-muted mt-1 fst-italic">Note: {{ $res->admin_note }}</div>
                                            @endif
                                        </td>
                                        <td class="text-end px-4">
                                            @if($res->status === 'pending')
                                                <form action="{{ route('customer.reservations.destroy', $res) }}" method="POST"
                                                    onsubmit="return confirm('Cancel this booking?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Cancel</button>
                                                </form>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-calendar-x display-4 mb-3 d-block"></i>
                                            You haven't made any reservations yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection