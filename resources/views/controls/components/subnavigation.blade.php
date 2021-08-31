@if(!empty($rooms) && count($rooms) > 0)
@foreach ($rooms as $room)
<li class="nav-item">
    <a class="nav-link {{ (((int)request()->segment(count(request()->segments())) === $room->id) ? 'active' : '') }}" href="{{ route('controls.room', $room->id) }}">{{ $room->name }}</a>
</li>
@endforeach
@endif