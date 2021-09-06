@extends('layouts.app')
@section('pageTitle', trans('simplehome.profile.administration.pageTitle') )
@section('content')
<div class="container">
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
                    <?php if (Session::get('verifyDelete')): ?>
                        {!! form($realyDeleteProfileForm) !!}
                    <?php else: ?>
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
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.privateToken')}}</div>

                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
