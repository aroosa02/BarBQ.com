@props(['status'])

@php
    $status = strtolower($status);
    $badgeClass = match ($status) {
        'pending', 'open' => 'bg-secondary',
        'preparing', 'in_progress', 'approved' => 'bg-warning text-dark',
        'ready', 'available' => 'bg-info text-dark',
        'completed', 'resolved' => 'bg-success',
        'cancelled', 'rejected' => 'bg-danger',
        default => 'bg-secondary',
    };

    $displayText = ucwords(str_replace('_', ' ', $status));
@endphp

<span class="badge {{ $badgeClass }}">
    {{ $displayText }}
</span>