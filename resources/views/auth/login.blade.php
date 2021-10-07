@extends('layouts.guest')
@section('pageTitle', trans('simplehome.auth.login.pageTitle') )
@section('content')
<form method="POST" class="form-signin" action="{{ route('login') }}">
    @csrf
    <div class="page page-login">
        <h1 class="text-center">
            <img class="img-responsive mb-4" src="{{ asset('images/logo.png') }}" alt="" height="72">
        </h1>
        <div class="login-form">
            <div class="mb-3">
                <label>Email address</label>
                <input type="email" id="email" class="form-control bg-light @error('email') is-invalid @enderror" placeholder="Email address" name="email" value="{{ old('email') }}" required required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="d-flex justify-content-between">Password
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" tabindex="-1">
                        {{ __('simplehome.passwordForgotten') }}
                    </a>
                    @endif
                </label>
                <input type="password" id="password" class="form-control bg-light @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="col-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="col-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="dashboard" id="dashboard">

                        <label class="form-check-label" for="dashboard">
                            Dashboard
                        </label>
                    </div>
                </div>
            </div>

            <button class="btn btn-lg btn-primary form-control" type="submit"> {{ __('simplehome.login') }}</button>
            <p class="text-center text-muted my-2">Or sign in with</p>
            <div class="buttons text-center">
                <button type="button" class="btn btn-light bg-white"><i class="fa fa-github"></i></button>
                <button type="button" class="btn btn-light bg-white"><i class="fa fa-google"></i></button>
            </div>
        </div>
        <div class="login-footer text-center mt-5">
            Don't have account yet? <a href="register"><b>Sign Up</b></a>
        </div>
    </div>
</form>
@endsection