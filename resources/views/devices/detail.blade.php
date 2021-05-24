@extends('layouts.app')

@section('content')
<div class="container">
    test
    {{$device->hostname}}
    {{$device->type}}
    {{$device->sleep}}
    {{$device->token}}

    {{$device->heartbeat}}
    {{$device->created}}

    @if (!empty($device->getProperties) && count($device->getProperties) > 0)
    <div class="col-md-12">
        <h2>{{ __('Properties List') }}</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Last Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($device->getProperties as $property)
                <tr>
                    <td>{{$property->name}}</td>
                    <td>{{$property->type}}</td>
                    <td>
                        @if (!empty($property->last_value->value))
                        {{$property->last_value->value}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-center">{{ __('Nothing Found') }}</p>
    @endif
</div>
@endsection
