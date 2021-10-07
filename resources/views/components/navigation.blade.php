@php
$notificationCount = auth()
    ->user()
    ->notifications->Count();
@endphp
<li class="nav-item">
    <a href="{{ route('controls.room') }}" class="nav-link {{ strpos(Route::currentRouteName(), 'controls') > -1 ? 'active' : '' }}">
        <i class="fa fa-home"></i><span class="d-none ms-md-2 d-md-inline">Rooms</span>
    </a>
</li>
<li class="nav-item">
    <a data-bs-toggle="modal" data-bs-target="#notifications" class="nav-link position-relative">
        <i class="fa fa-bell">
            @if ($notificationCount > 0)
                <span class="position-absolute top-0 p-1 bg-danger border border-light rounded-circle d-inline d-md-none">
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </i>
        <span class="d-none ms-md-2 d-md-inline">Events</span>
        @if ($notificationCount > 0)
            <span class="d-none ms-md-2 d-md-inline badge rounded-pill bg-danger">{{ $notificationCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('automations_list') }}" class="nav-link disabled">
        <i class="fa fa-clock"></i><span class="d-none ms-md-2 d-md-inline">Automations</span>
    </a>
</li>
<li>
    <a href="{{ route('system.profile') }}" class="nav-link {{ strpos(Route::currentRouteName(), 'system') > -1 ? 'active' : '' }}">
        <i class="fa fa-cog"></i></i><span class="d-none ms-md-2 d-md-inline">Settings</span>
    </a>
</li>
