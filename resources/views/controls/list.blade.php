@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
@include('controls.components.subnavigation', $rooms)
@endsection

@section('content')
@if(!empty($propertyes) && count($propertyes) > 0)
<div class="row">
    @foreach ($propertyes as $property)
    <div class="col-lg-2 col-md-4 col-6 p-0">
        @include('controls.components.item', $property)
    </div>
    @endforeach
</div>
@else
<p class="text-center">{{ __('simplehome.controls.notFound') }}</p>
@endif
@endsection