<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'controls') > -1) ? 'active' : '') }}" href="{{ route('controls.room') }}"><i class="fas fa-home" style="font-size: 22px; margin: auto;"></i></a>
</li>
<li class="nav-item">
    <a class="nav-link disabled" style="margin: auto;" href="{{ route('automations_list') }}"><i class="fa fa-clock-o" style="font-size: 22px;"></i></a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'system') > -1) ? 'active' : '') }}" href="{{ route('system.user.profile') }}"><i class="fas fa-cog" style="font-size: 22px;"></i></a>
</li>