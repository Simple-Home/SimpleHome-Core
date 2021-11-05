@extends('layouts.settings')
@section('pageTitle', 'integrations')
@section('content')

    <div class="container">
        <div class="col-md order-md-1 order-1 p-md-0 my-auto col-6">
            <a style="font-weight:bold" class="h4 text-capitalize text-decoration-none fw-bold"
                href="{{ route('controls.room', $property->room->id) }}"><i
                    class="fas fa-chevron-left me-2"></i>{{ $property->room->name }}</a>
        </div>
        @if (!empty($settings) && count($settings) > 0)
            <div class="col">
                <div class="row row-cols-1 row-cols-md-3">
                    {!! form($systemSettingsForm) !!}
                </div>
            </div>
        @else
            <p class="text-center">{{ __('No Modules Found') }}</p>
        @endif
    </div>
@endsection
