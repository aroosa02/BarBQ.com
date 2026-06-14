@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow rounded-4 border-0 mt-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="BarBQ.com" height="80"
                            class="mb-3 rounded-circle shadow">
                        <h2 class="fw-bold">Welcome Back</h2>
                        <p class="text-muted">Enter your credentials to continue</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-bbq-primary btn-lg rounded-pill">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Don't have an account? <a href="{{ route('register') }}"
                                class="text-bbq-primary fw-bold">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection