<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('devices_list') }}">{{ __('simplehome.devices.pageTitle') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('properties_list') }}">{{ __('simplehome.properties.list.pageTitle') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="{{ route('automations_list') }}">{{ __('simplehome.automations.list.pageTitle') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users_list') }}">{{ __('simplehome.users.list.pageTitle') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rooms_list') }}">{{ __('simplehome.rooms.list.pageTitle') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('server_info') }}">{{ __('simplehome.server.detail.pageTitle') }}</a>
    </li>
</ul>
