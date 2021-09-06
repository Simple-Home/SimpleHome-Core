@section('pageTitle', trans('simplehome.properties.detail.pageTitle') )
@extends('layouts.app')

@section('subnavigation')
@include('settings.components.subnavigation')
@endsection

@section('content')

<div class="container">
    <div class="row">
    </div>
    @if(!empty($settings) && count($settings) > 0)
    <div class="col">
        <div class="row row-cols-1 row-cols-md-3">
            @foreach ($settings as $setting)
            {!! form($systemSettingsForm) !!}
            @endforeach
        </div>
    </div>
    @else
    <p class="text-center">{{ __('No System Settings Found') }}</p>
    @endif
</div>
@endsection