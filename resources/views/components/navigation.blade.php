<li class="nav-item">
    <a href="{{ route('controls.room') }}" class="nav-link {{ ((strpos(Route::currentRouteName(), 'controls') > -1) ? 'active' : '') }}">
        <i class="fa fa-home"></i><span class="d-none ms-md-2 d-md-inline">Rooms</span>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('automations_list') }}" class="nav-link disabled">
        <i class="fa fa-clock-o"></i><span class="d-none ms-md-2 d-md-inline">Automations</span>
    </a>
</li>
<li>
    <a href="{{ route('system.user.profile') }}" class="nav-link {{ ((strpos(Route::currentRouteName(), 'system') > -1) ? 'active' : '') }}">
        <i class="fa fa-cog"></i></i><span class="d-none ms-md-2 d-md-inline">Settings</span>
    </a>
</li>