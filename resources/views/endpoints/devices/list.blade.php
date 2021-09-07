@extends('layouts.app')
@section('title', trans('simplehome.endpoint.panelTitle'))

@section('subnavigation')
@include('endpoints.components.subnavigation')
@endsection

@section('content')
<div class="container p-0">
    @if(!empty($devices) && count($devices) > 0)
    <div class="row m-n1">
        @foreach ($devices as $device)
        <div class="col-lg-4 col-md-6 col-12 p-0">
            @include('endpoints.components.device', $device)
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center">{{ __('simplehome.noDevices') }}</p>
    @endif
</div>
@endsection