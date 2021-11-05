@extends('layouts.settings')
@section('title', 'profile')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="container p-0 pt-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('simplehome.profile.informations') }}</div>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="d-inline my-auto">
                                <i class="h2 d-inline fas fa-sun"></i>
                            </div>
                            <div class="h2 d-inline mx-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexDarkModeSwitch">
                                    <label class="form-check-label" for="flexDarkModeSwitch"></label>
                                </div>
                            </div>
                            <div class="d-inline my-auto">
                                <i class="h2 d-inline fas fa-moon"></i>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('#flexDarkModeSwitch').prop("checked", darkThemeSelected)
                                });

                                $('#flexDarkModeSwitch').change(function() {
                                    if ($(this).prop("checked")) {
                                        document.body.setAttribute("data-theme", "dark");
                                        localStorage.setItem("darkSwitch", "dark");
                                        $('head meta[name="theme-color"]').attr('content', '#111');
                                    } else {
                                        document.body.removeAttribute("data-theme");
                                        localStorage.removeItem("darkSwitch");
                                        $('head meta[name="theme-color"]').attr('content', '#F0F1F5');
                                    }
                                });
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('simplehome.profile.informations') }}</div>
                    <div class="card-body">
                        {!! form($profileInformationForm) !!}
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row justify-content-center" id="notifications">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('user.notifications') }}</div>

                    <div class="card-body">
                        {!! form($notificationForm) !!}
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row justify-content-center" id="locator">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('user.locator') }}</div>

                    <div class="card-body">
                        {!! form($locatorForm) !!}
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
                    <div class="card-header">{{ __('simplehome.mfaLong') }}</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
