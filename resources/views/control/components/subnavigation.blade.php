<ul class="navbar-nav mr-auto">
    @if(!empty($rooms) && count($rooms) > 0)
    @foreach ($rooms as $room)
    <li class="nav-item">
        <a class="nav-link {{ ((strpos(Route::currentRouteName(), 'control_room') > -1) ? 'active' : '') }}" href="{{ route('control_room', $room->id) }}">{{ $room->name }}</a>
    </li>
    @endforeach
    @endif
</ul>