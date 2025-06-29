@extends('layouts.auth')
@section('title', 'Lupa Password')
@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4 text-center">Lupa Password</h4>
            <form method="POST" action="{{ url('/forgot-password') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                @if(session('status'))
                    <div class="alert alert-success py-2">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                @endif
                <button type="submit" class="btn btn-warning w-100">Kirim Link Reset</button>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
