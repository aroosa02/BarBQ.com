@extends('layouts.app')

@section('nav-links')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
            href="{{ route('customer.dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Browse Menu</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Active Deals</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">My Reservations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">My Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Support/Complaints</a>
    </li>
@endsection