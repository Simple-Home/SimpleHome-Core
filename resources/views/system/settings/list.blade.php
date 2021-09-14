@section('pageTitle', trans('simplehome.properties.detail.pageTitle') )
@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
    </div>
    @if(!empty($settings) && count($settings) > 0)
    <div class="col">
        <div class="row row-cols-1 row-cols-md-3">
            {!! form($systemSettingsForm) !!}
        </div>
    </div>
    @else
    <p class="text-center">{{ __('No System Settings Found') }}</p>
    @endif
</div>
@endsection