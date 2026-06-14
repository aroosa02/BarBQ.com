@extends('layouts.app')

@section('styles')
    <style>
        .admin-container {
            display: flex;
            min-height: calc(100vh - 120px);
        }

        .admin-sidebar {
            width: 250px;
            background-color: var(--bbq-surface);
            border-right: 1px solid var(--bbq-border);
            padding: 1.5rem 0;
        }

        .admin-content {
            flex: 1;
            padding: 1.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--bbq-text);
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: var(--bbq-primary);
            color: #fff;
        }

        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--bbq-border);
            }
        }
    </style>
@endsection

@section('content')
    <div class="admin-container rounded-4 shadow-sm overflow-hidden">
        <div class="admin-sidebar">
            <div class="px-4 mb-4 text-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Admin Logo" height="60"
                    class="mb-2 rounded-circle shadow-sm border border-bbq-primary">
                <h5 class="fw-bold text-bbq-primary mb-0">Admin Panel</h5>
                <small class="text-muted">Management Console</small>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Categories
                </a>
                <a href="{{ route('admin.menu-items.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                    <i class="bi bi-egg-fried"></i> Menu Items
                </a>
                <a href="{{ route('admin.deals.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.deals.*') ? 'active' : '' }}">
                    <i class="bi bi-percent"></i> Deals
                </a>
                <a href="{{ route('admin.reservations.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Reservations
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart3"></i> Orders
                </a>
                <a href="{{ route('admin.expenses.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> Expenses
                </a>
                <a href="{{ route('admin.complaints.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-dots"></i> Complaints
                </a>
            </nav>
        </div>
        <div class="admin-content">
            @yield('admin-content')
        </div>
    </div>
@endsection