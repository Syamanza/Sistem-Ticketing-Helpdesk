@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Welcome Back</h3>
                    <p class="text-muted">Sign in to access your dashboard</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required autofocus value="{{ old('email') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Login Now</button>
                </form>

                <hr class="my-4">

                <div class="text-center small">
                    <p class="text-muted mb-2 fw-semibold">Demo Accounts:</p>
                    <p class="mb-1">IT Support: <code class="bg-light px-2 py-1 rounded">support@company.com</code></p>
                    <p class="mb-1">Employee: <code class="bg-light px-2 py-1 rounded">employee@company.com</code></p>
                    <p class="mt-2 text-muted"><em>Password: <code>password</code></em></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
