<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'profile') > -1) ? 'active' : '')}}" title="test" href="{{route('system.user.profile')}}">Profile</a>
</li>
<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'diagnostics') > -1) ? 'active' : '')}}" title="test" href="">Diagnostics</a>
</li>
<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'integrations') > -1) ? 'active' : '')}}" title="test" href="{{route('system.integrations.list')}}">Integrations</a>
</li>
<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'housekeepings') > -1) ? 'active' : '')}}" title="test" href="{{route('system.housekeepings')}}">Housekeeping</a>
</li>
<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'users') > -1) ? 'active' : '')}}" title="test" href="{{route('system.users.list')}}">Users</a>
</li>
<li class="nav-item my-auto">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'rooms') > -1) ? 'active' : '')}}" title="test" href="{{route('system.rooms.list')}}">Rooms</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'packups') > -1) ? 'active' : '')}}" href="{{ route('system.backups') }}">{{ __('Backups') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'devices') > -1) ? 'active' : '')}}" href="{{ route('system.devices.list') }}">{{ __('Devices') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'settings') > -1) ? 'active' : '')}}" href="{{ route('system.settings.list') }}">{{ __('settings') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'developments') > -1) ? 'active' : '')}}" href="{{ route('system.developments.list') }}">{{ __('developments') }}</a>
</li>