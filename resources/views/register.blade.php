@extends('layouts.master')

@section('title', 'Registration Page')

@section('content')
    <div class="login-form">
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input class="au-input au-input--full form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Username" value="{{ old('name') }}">
            </div>
            @error('name')
            <div class="mb-4">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror

            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            @error('email')
            <div class="mb-4">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror

            <div class="form-group">
                <label>Phone Number</label>
                <input class="au-input au-input--full form-control @error('phone') is-invalid @enderror" type="number" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
            </div>
            @error('phone')
            <div class="mb-4">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror

            <div class="form-group">
                <label>Address</label>
                <input class="au-input au-input--full form-control @error('address') is-invalid @enderror" type="text" name="address" placeholder="Address" value="{{ old('address') }}">
            </div>
            @error('address')
            <div class="mb-4">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror

            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
            </div>
            @error('password')
            <div class="mb-4">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror

            <div class="form-group">
                <label>Confirm Password</label>
                <input class="au-input au-input--full form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password">
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{ route('auth#loginPage') }}" class="text-decoration-none">Sign In</a>
            </p>
        </div>
    </div>
@endsection

