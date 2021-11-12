@extends('layouts.settings')
@section('title', 'rooms')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    @include('components.search')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">{{ __('simplehome.oauth.clients') }}
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roomCreation"
                title="{{ __('simplehome.room.create') }}">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="card-body">


            @if (!empty($rooms) && count($rooms) > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('simplehome.room.name') }}</th>
                                <th class="col-auto text-end fit">{{ __('simplehome.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td class="col-auto">
                                        {!! form($roomsForm[$room->id]) !!}
                                    </td>
                                    <td class="col-auto text-end fit">
                                        <div class="btn btn-info p-1">
                                            @if ($room->default)
                                                <a href="{{ route('system.rooms.default', ['room_id' => $room->id]) }}"
                                                    class="btn btn-primary" title="{{ __('simplehome.room.default') }}"><i
                                                        class="fas fa-toggle-on"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('system.rooms.default', ['room_id' => $room->id]) }}"
                                                    class="btn btn-primary"
                                                    title="{{ __('simplehome.room.default.remove') }}"><i
                                                        class="fas fa-toggle-off"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('system.rooms.remove', ['room_id' => $room->id]) }}"
                                                class="btn btn-danger" title="{{ __('simplehome.room.delete') }}"><i
                                                    class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">{{ __('No Rooms Found') }}</p>
            @endif
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="roomCreation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="roomCreation" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('simplehome.room.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! form($roomForm) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
@endsection
