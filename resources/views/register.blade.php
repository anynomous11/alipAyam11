@extends('layouts.auth')
@section('title', 'Register')
@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4 text-center">Register</h4>
            <form method="POST" action="{{ url('/register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                @endif
                <button type="submit" class="btn btn-success w-100">Register</button>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
