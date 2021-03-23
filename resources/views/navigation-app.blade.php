<div class="layout-nav">
    <ul class="app-nav nav flex-column">
        <li class="nav-item {{ Request::is('home*') || Request::is('/') ? 'is-active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">{{ __('ui.overview') }}</a>
        </li>
    </ul>
</div>
