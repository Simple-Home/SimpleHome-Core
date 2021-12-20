@if (!empty($rooms) && count($rooms) > 0)
    @foreach ($rooms as $room)
        <li class="nav-item">
            <div class="nav-link subnavigation user-select-none" data-room-id="{{ $room->id }}"
                data-url="{{ route('controls.ajax.list', ['room_id' => $room->id]) }}">{{ $room->name }}</div>
        </li>
    @endforeach
@endif
