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
            <div class="form-group">
                <label>Email address</label>
                <input type="email" id="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email address" name="email" value="{{ old('email') }}" required required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="d-flex justify-content-between">Password
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" tabindex="-1">
                        {{ __('simplehome.passwordForgotten') }}
                    </a>
                    @endif
                </label>
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit"> {{ __('simplehome.login') }}</button>
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