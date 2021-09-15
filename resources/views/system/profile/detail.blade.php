@extends('layouts.app')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.profile.informations')}}</div>
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('simplehome.logout') }}
                </a>
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
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.oauth.clients')}}</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Client ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Secret</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$client->id}}</td>
                                <td>{{$client->name}}</td>
                                <td><code>{{$client->secret}}</code></td>
                                <td>
                                    <a class="btn bg-info" href="btn" role="button">edit</a>
                                    <a class="btn btn-danger" href="btn" role="button">delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.oauth.personal.access.tokens')}}</div>
                <?php var_dump($tokens); ?>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection