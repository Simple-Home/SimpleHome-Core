   <ul class="navbar-nav mr-auto nav-pills">
       <li class="nav-item">
           <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'endpoint.devices.list') > -1) ? 'active' : '') }}" href="{{ route('endpoint.devices.list') }}">{{ __('simplehome.devices.pageTitle') }}</a>
       </li>
       <li class="nav-item">
           <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'endpoint.properties.list') > -1) ? 'active' : '') }}" href="{{ route('endpoint.properties.list') }}">{{ __('simplehome.properties.list.pageTitle') }}</a>
       </li>
   </ul>