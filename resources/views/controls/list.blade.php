@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
@include('controls.components.subnavigation', $rooms)
@endsection

@section('content')
<div id="ajax-content" class="align-items-center" data-url="{{route('controls.ajax.list', ['room_id' => $selected_room_id])}}">
    <div class="text-center h-100">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<!-- TODO:Načítat AJAXEM -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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