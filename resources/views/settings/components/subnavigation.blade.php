<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('server_info') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('housekeeping') }}">{{ __('Houskeeping') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('integrations_list') }}">{{ __('Integrations') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="{{ route('server_info') }}">{{ __('Logs') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backup') }}">{{ __('Backups') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('system_settings') }}">{{ __('System') }}</a>
    </li>
</ul>
