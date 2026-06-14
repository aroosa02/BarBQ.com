@extends('layouts.admin')

@section('title', 'Manage Reservations')

@section('admin-content')
    <div class="mb-4">
        <h3 class="fw-bold">Reservations</h3>
        <p class="text-muted">Review and manage customer table bookings.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Customer</th>
                            <th class="py-3">Date & Time</th>
                            <th class="py-3">Guests</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $res)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold">{{ $res->user->name }}</div>
                                    <div class="text-muted small">{{ $res->user->email }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('M d, Y') }}</div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($res->reservation_time)->format('h:i A') }}</div>
                                </td>
                                <td><span class="badge bg-secondary rounded-pill px-3">{{ $res->guests }} People</span></td>
                                <td>
                                    @include('components.status-badge', ['status' => $res->status])
                                </td>
                                <td class="text-end px-4">
                                    @if($res->status === 'pending')
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $res->id }}"
                                                onclick="setStatus({{ $res->id }}, 'approved')">
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $res->id }}"
                                                onclick="setStatus({{ $res->id }}, 'rejected')">
                                                Reject
                                            </button>
                                        </div>

                                        <!-- Status Update Modal -->
                                        <div class="modal fade" id="statusModal{{ $res->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-4 shadow">
                                                    <form action="{{ route('admin.reservations.updateStatus', $res) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" id="modalStatus{{ $res->id }}">
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="modal-title fw-bold" id="modalTitle{{ $res->id }}">Update
                                                                Reservation</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p id="modalMsg{{ $res->id }}">Are you sure you want to update this
                                                                reservation?</p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Optional Note for
                                                                    Customer</label>
                                                                <textarea name="admin_note" class="form-control" rows="3"
                                                                    placeholder="e.g. Sorry, we are fully booked for this slot."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-light rounded-pill"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-bbq-primary rounded-pill px-4">Confirm
                                                                Action</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($res->admin_note)
                                        <small class="text-muted fst-italic">Note: {{ Str::limit($res->admin_note, 20) }}</small>
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No reservations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function setStatus(id, status) {
            document.getElementById('modalStatus' + id).value = status;
            const title = document.getElementById('modalTitle' + id);
            const msg = document.getElementById('modalMsg' + id);

            if (status === 'approved') {
                title.innerHTML = '<i class="bi bi-check-circle text-success"></i> Approve Reservation';
                msg.innerHTML = 'Approve booking for {{ $res->user->name ?? 'customer' }} on this date?';
            } else {
                title.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Reject Reservation';
                msg.innerHTML = 'Reject booking for {{ $res->user->name ?? 'customer' }}. You can provide a reason below.';
            }
        }
    </script>
@endsection