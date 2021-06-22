@extends('layouts.app')

@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h2>{{ __('Properties List') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
    @if (!empty($properties) && count($properties) > 0)         
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
                                        <h5 class="text-right">{{round($property->last_value->value ,2)}}</h5>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @include('properties.components.controls', $property)
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
        <p class="text-center">{{ __('No Properties Found') }}</p>
    @endif
</div>
@endsection
