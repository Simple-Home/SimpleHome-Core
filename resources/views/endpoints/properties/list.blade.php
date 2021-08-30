@extends('layouts.app')

@section('subnavigation')
@include('endpoints.components.subnavigation')
@endsection

@section('content')
@if(!empty($properties) && count($properties) > 0)
<div class="row row-cols-1 row-cols-md-3">
    @foreach ($properties as $property)
    <div class="col mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <h5 class="card-title">
                            <a href="{{ route('properties_detail', $property->id) }}">
                                <i class="fas {{$property->icon}}"></i> {{strtoupper($property->device->hostname)}}: {{ucwords($property->nick_name)}}
                            </a>
                        </h5>
                    </div>

                    @if (!empty($property->last_value->value))
                    <div class="col-xs">
                        <h5 class="text-right">
                            @if (is_numeric($property->last_value->value))
                            {{ round($property->last_value->value, 2) }}
                            @else
                            {{ $property->last_value->value }}
                            @endif

                        </h5>
                    </div>
                    @endif
                </div>
                <div class="row">

                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    <p class="mb-0 {{ $property->connection_error ? 'text-danger' : 'text-success' }}">Last updated {{$property->connection_ago}}</p>
                </small>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-center">{{ __('simplehome.noDevices') }}</p>
@endif
@endsection