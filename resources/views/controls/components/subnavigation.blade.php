@if(!empty($rooms) && count($rooms) > 0)
@foreach ($rooms as $room)
<li class="nav-item">
    <a class="nav-link {{ (((int)request()->segment(count(request()->segments())) === $room->id) ? 'active' : '') }}" href="{{ route('controls.room', $room->id) }}">{{ $room->name }}</a>
</li>
@endforeach
<li class="nav-item my-auto">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="{{ __('simplehome.room.create') }}">
        <i class="fas fa-plus"></i>
    </button>
</li>
@endif