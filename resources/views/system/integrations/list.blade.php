@extends('layouts.app')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container p-0">
    @if(!empty($integrations) && count($integrations) > 0)
    <div class="row m-n1">
        @foreach ($integrations as $integration)
        <div class="col-lg-4 col-md-6 col-12 p-0">
            @include('system.components.integration', $integration)
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center">{{ __('simplehome.noIntegration') }}</p>
    @endif
</div>
@endsection