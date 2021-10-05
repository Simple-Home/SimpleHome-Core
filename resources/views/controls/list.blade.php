@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
@include('controls.components.subnavigation', $rooms)
@endsection

@section('content')
@if(!empty($propertyes) && count($propertyes) > 0)
<div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    @foreach ($propertyes as $property)
    <div class="col-lg-2 col-md-4 col">
        @include('controls.components.item', $property)
    </div>
    @endforeach
</div>
@else
<p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
@endif
@endsection

<!-- Modal -->
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