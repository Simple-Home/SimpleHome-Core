@extends('layouts.guest')
@section('pageTitle', trans('simplehome.auth.login.pageTitle') )
@section('content')
<form method="POST" class="form-signin" action="{{ route('login') }}">
    @csrf
    <div class="text-center mb-4">
        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Simple-Home</h1>
    </div>

    <div class="form-label-group">
        <input type="email" id="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email address" name="email" value="{{ old('email') }}" required required autofocus>
        <label for="email">Email address</label>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-label-group">
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required>
        <label for="password">Password</label>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('simplehome.rememberMe') }}
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit"> {{ __('simplehome.login') }}</button>

    @if (Route::has('password.request'))
    <a class="mt-5 mb-3 text-center" href="{{ route('password.request') }}">
        {{ __('simplehome.passwordForgotten') }}
    </a>
    @endif

    <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
</form>
@endsection