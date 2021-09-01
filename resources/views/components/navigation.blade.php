<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'controls') > -1) ? 'active' : '') }}" href="{{ route('controls.room') }}"><i class="fas fa-home" style="font-size: 22px; margin: auto;"></i></a>
</li>
<li class="nav-item">
    <a class="nav-link disabled" style="margin: auto;" href="{{ route('automations_list') }}"><i class="fa fa-clock-o" style="font-size: 22px;"></i></a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'endpoint') > -1) ? 'active' : '') }}" href="{{ route('endpoint.properties.list') }}"><i class="fas fa-microchip" style="font-size: 22px;"></i></a>
</li>
<li class="nav-item">
    <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'server_info') > -1) ? 'active' : '') }}" href="{{ route('server_info') }}"><i class="fas fa-sliders-h" style="font-size: 22px;"></i></a>
</li>