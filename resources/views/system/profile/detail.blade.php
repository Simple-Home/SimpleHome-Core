@extends('layouts.app')
@section('title', 'profile')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container p-0">
    <div class="row pb-2">
        <div class="col p-0">
            <div class="card">
                <div class="card-header">TITLE</div>
                <div class="card-body">
                    BODY
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.profile.informations')}}</div>
                <div class="card-body">
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('simplehome.logout') }}
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.profile.informations')}}</div>
                <div class="card-body">
                    <div>
                        <i class="d-inline fas fa-sun"></i>
                        <div class="d-inline custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="darkSwitch" />
                            <label class="custom-control-label" for="darkSwitch"></label>
                        </div>
                        <i class="d-inline fas fa-moon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.profile.informations')}}</div>
                <div class="card-body">
                    {!! form($profileInformationForm) !!}
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center" id="settings">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('user.setting') }}</div>

                <div class="card-body">
                    {!! form($settingForm) !!}
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('simplehome.changePassword') }}</div>
                <div class="card-body">
                    {!! form($changePasswordForm) !!}
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('simplehome.users.delete') }}</div>
                <div class="card-body">
                    <?php if (Session::get('verifyDelete')) : ?>
                        {!! form($realyDeleteProfileForm) !!}
                    <?php else : ?>
                        {!! form($deleteProfileForm) !!}
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.mfaLong')}}</div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection