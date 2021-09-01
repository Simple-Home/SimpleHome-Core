@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
@include('controls.components.subnavigation', $rooms)
@endsection

@section('content')
<div class="container p-0">
    @if(!empty($propertyes) && count($propertyes) > 0)
    <div class="row m-n1">
        @foreach ($propertyes as $property)
        <div class="col-lg-2 col-md-4 col-6 p-0">
            @include('controls.components.item', $property)
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center">{{ __('simplehome.controls.notFound') }}</p>
    @endif
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">{{ __('simplehome.room.create') }}</div>

                <div class="card-body">
                    {!! form($roomForm) !!}
                </div>
            </div>
        </div>
    </div>
</div>