<nav class="navbar navbar-expand-md sticky-top py-0">
    <div class="collapse navbar-collapse nav-pills" id="navbarTogglerDemo01">
        <div class="subNav ">
            {{-- Menu Items Start --}}
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <a class="nav-link {{ strpos($pageSelector, 'profile') > -1 ? 'active' : '' }} ps-1" title="test"
                        href="{{ route('system.profile') }}">
                        <img src="{{ auth()->user()->getGavatarUrl() }}" alt="{{ auth()->user()->name }}"
                            style="height: 30px; width:30px" class="my-auto rounded-circle border-primary border-3 ms-1">
                        <span class="py-auto ms-1">{{ auth()->user()->name }}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <p class="m-0">{{ __('general') }}</p>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto ">
                    <a class="nav-link  {{ strpos($pageSelector, 'integrations') > -1 ? 'active' : '' }}" title="test"
                        href="{{ route('system.integrations.list') }}">
                        <i class="fas fa-th-large"></i>
                        <span class="ms-md-2 ">{{ __('Integrations') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto ">
                    <a class="nav-link {{ strpos($pageSelector, 'housekeepings') > -1 ? 'active' : '' }}" title="test"
                        href="{{ route('system.housekeepings') }}">
                        <i class="fas fa-recycle"></i>
                        <span class="ms-md-2 ">{{ __('Housekeeping') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto ">
                    <a class="nav-link {{ strpos($pageSelector, 'users') > -1 ? 'active' : '' }}" title="test"
                        href="{{ route('system.users.list') }}">
                        <i class="fas fa-users"></i>
                        <span class="ms-md-2 ">{{ __('Users') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'developments') > -1 ? 'active' : '' }}"
                        href="{{ route('system.developments.index') }}">
                        <i class=" fa fa-bell"></i>
                        <span class="ms-md-2 ">{{ __('Developments') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <p class="m-0">{{ __('home') }}</p>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <a class="nav-link {{ strpos($pageSelector, 'rooms') > -1 ? 'active' : '' }}" title="test"
                        href="{{ route('system.rooms.list') }}">
                        <i class=" fa fa-home"></i>
                        <span class="ms-md-2 ">{{ __('Rooms') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'locations') > -1 ? 'active' : '' }}"
                        href="{{ route('system.locations.index') }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="ms-md-2 ">{{ __('Locations') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'devices') > -1 ? 'active' : '' }}"
                        href="{{ route('system.devices.list') }}">
                        <i class="fas fa-ethernet"></i>
                        <span class="ms-md-2 ">{{ __('Devices') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <p class="m-0">{{ __('system') }}</p>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto ">
                    <a class="nav-link  {{ strpos($pageSelector, 'diagnostics') > -1 ? 'active' : '' }}" title="test"
                        href="{{ route('system.diagnostics.list') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="ms-md-2 ">{{ __('Diagnostics') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'settings') > -1 ? 'active' : '' }}"
                        href="{{ route('system.settings.list') }}">
                        <i class="fas fa-cog"></i>
                        <span class="ms-md-2 ">{{ __('Settings') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'backups') > -1 ? 'active' : '' }}"
                        href="{{ route('system.backups') }}">
                        <i class="fas fa-file-archive"></i>
                        <span class="ms-md-2 ">{{ __('Backups') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'env') > -1 ? 'active' : '' }}"
                        href="{{ route('system.env') }}">
                        <i class="fas fa-code"></i>
                        <span class="ms-md-2 ">{{ __('Env  Editor') }}</span></a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item my-auto">
                    <p class="m-0">{{ __('simplehome.debug') }}</p>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'logs') > -1 ? 'active' : '' }}"
                        href="{{ route('system.logs') }}">
                        <i class="fas fa-bug"></i>
                        <span class="ms-md-2 ">{{ __('Logs') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos($pageSelector, 'pwa') > -1 ? 'active' : '' }}"
                        href="{{ route('system.pwa') }}">
                        <i class="fas fa-bug"></i>
                        <span class="ms-md-2 ">{{ __('simplehome.pwa') }}</span>
                    </a>
                </li>
            </ul>
            {{-- Menu Items End --}}
        </div>
    </div>
</nav>
