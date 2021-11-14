@extends('layouts.settings')
@section('pageTitle', trans('simplehome.properties.detail.pageTitle') )
@section('content')
    @include('system.components.controls', $integration)
    @if(!empty($settings) && count($settings) > 0)
    <div class="col">
        <div class="row row-cols-1 row-cols-md-3">
            {!! form($systemSettingsForm) !!}
        </div>
    </div>
    @else
    <p class="text-center">{{ __('No Modules Found') }}</p>
    @endif
@endsection
