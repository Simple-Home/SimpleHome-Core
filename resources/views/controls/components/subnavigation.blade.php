@if(!empty($rooms) && count($rooms) > 0)
@foreach ($rooms as $room)
<li class="nav-item">
    <a class="nav-link {{ (((int)request()->segment(count(request()->segments())) === $room->id) ? 'active' : '') }}" href="{{ route('controls.room', $room->id) }}">{{ $room->name }}</a>
</li>
@endforeach
<li class="nav-item my-auto">
    <a class="nav-link btn btn-primary" data-toggle="modal" data-target="#exampleModal" title="{{ __('simplehome.room.create') }}" href="#"><i class="fas fa-plus"></i></a>
</li>
@endif