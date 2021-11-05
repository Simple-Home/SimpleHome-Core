@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
    <div class="ajax-subnavigation" data-url="{{ route('controls.ajax.subnavigation') }}"></div>
@endsection

@section('content')
    <div id="carouselExampleSlidesOnly" class="carousel slide h-100" data-bs-wrap="false" data-bs-keyboard="true"
        data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="false">
        <div class="carousel-inner h-100">
            @foreach ($rooms as $room)
                <div class="carousel-item h-100" data-room-id="{{ $room->id }}"
                    data-url="{{ route('controls.ajax.list', ['room_id' => $room->id]) }}">
                    <div class="d-flex h-100">
                        <div class="text-center m-auto">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <!-- TODO:Načítat AJAXEM -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
