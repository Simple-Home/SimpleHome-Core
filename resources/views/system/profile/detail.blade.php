@extends('layouts.settings')
@section('title', 'profile')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="card mb-3">
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
    <div class="card mb-3">
        <div class="card-header">{{ __('simplehome.profile.informations') }}</div>
        <div class="card-body">
            {!! form($profileInformationForm) !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ __('user.notifications') }}</div>
        <div class="card-body">
            {!! form($notificationForm) !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ __('user.locator') }}</div>
        <div class="card-body">
            {!! form($locatorForm) !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ __('user.setting') }}</div>

        <div class="card-body">
            {!! form($settingForm) !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ __('simplehome.changePassword') }}</div>
        <div class="card-body">
            {!! form($changePasswordForm) !!}
        </div>
    </div>
    @if (env('SESSION_DRIVER') == 'database')
        <div class="card mb-3">
            <div class="card-header">{{ __('simplehome.sessions') }}</div>
            <div class="card-body">
                @if (!empty($sessions) && count($sessions) > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="d-none d-md-table-cell">{{ __('simplehome.ip.address') }}</th>
                                    <th>{{ __('simplehome.user.agent') }}</th>
                                    <th class="col-auto text-end fit">{{ __('simplehome.last.activity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td class="d-none d-md-table-cell">{{ $session->ip_address }}</td>
                                        <td class="d-none d-md-table-cell">{{ $session->user_agent['name'] }}</td>
                                        <td class="d-none d-md-table-cell">{{ $session->last_activity->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">{{ __('simplehome.sessions.notFound') }}</p>
                @endif
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">{{ __('simplehome.users.delete') }}</div>
        <div class="card-body">
            <?php if (Session::get('verifyDelete')) : ?>
            {!! form($realyDeleteProfileForm) !!}
            <?php else : ?>
            {!! form($deleteProfileForm) !!}
            <?php endif; ?>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ __('simplehome.mfaLong') }}</div>
        <div class="card-body">
        </div>
    </div>
    <div class="nav-bar-padding"></div>
@endsection
