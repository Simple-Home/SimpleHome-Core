@if(!empty($rooms) && count($rooms) > 0)
@foreach ($rooms as $room)
<li class="nav-item">
    <div id="ajax-loader" class="nav-link subnavigation user-select-none{{ (((int)request()->segment(count(request()->segments())) === $room->id) ? 'active' : '') }}" data-target-id="ajax-content" data-url="{{route('controls.ajax.list', ['room_id' => $room->id])}}">{{ $room->name }}</div>
</li>
@endforeach
<li class="nav-item my-auto">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="{{ __('simplehome.room.create') }}">
        <i class="fas fa-plus"></i>
    </button>
</li>
@endif