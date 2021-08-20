@extends('layouts.app')

@section('subnavigation')
@include('settings.components.subnavigation')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if(!empty($integrationList) && count($integrationList) > 0)
            <div class="col">
                <div class="row row-cols-1 row-cols-md-3">
                    @foreach ($integrationList as $integration)
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('integration_detail', strtolower($integration)) }}">
                                    {{ $integration }}
                                </a>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="text-center">{{ __('No Integrations Found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection