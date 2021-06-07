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
            <a href="{{ route('properties_detail', $property->id) }}" class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <i class="card-img-top fas {{$property->icon}}"></i>
                            <h5 class="card-title">{{$property->type}}</h5>
                            <h4>{{$property->device->hostname}}</h5>
                        </div>
                        <div class="col-sm">
                            @if (!empty($property->last_value->value))
                            <h4 class="text-right">{{$property->last_value->value}}</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <p class="mb-0 {{ $property->connection_error ? 'text-danger' : 'text-success' }}">Last updated {{$property->connection_ago}}</p>
                    </small>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
        <p class="text-center">{{ __('No Properties Found') }}</p>
    @endif
</div>
@endsection
