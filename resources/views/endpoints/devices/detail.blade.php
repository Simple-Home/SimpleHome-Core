@extends('layouts.detail')
@section('pageTitle', trans('simplehome.devices.detail.pageTitle') )
@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <div class="row justify-content-between">
                <div class="col p-md-0">
                    <a style="font-weight:bold" class="h4 fw-bold" href="#">{{"< Endpoints"}}</a>
                </div>
                <div class="col p-md-0 text-right my-auto">
                    <a style="font-weight:bold" class="h3 fw-bold" href="{{route('endpoints.devices.edit', $device->id)}}"><i class="fas fa-cog"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <div>
                <h3 class="mb-0">{{$device->hostname}}</h3>
                <p class="mb-0">{{$device->heartbeat}}</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <div>Diagnostic Information</div>
            @if (!empty(round($device->created)))
            {{ __('First Seen') }}: {{$device->createdat}}</br>
            @endif
            {{ __('Last Seen') }}: {{$device->heartbeat}}</br>
            {{ __('Ip Address') }}:</br>
            {{ __('Gateway') }}:</br>
            {{ __('subnet') }}:</br>
            @if (!empty(round($device->signal_strength)))
            {{ __('Signal') }}: {{$device->signal_strength}} %</br>
            @endif
            @if (!empty(round($device->battery_level)))
            {{ __('Battery') }}: {{round($device->battery_level, 2)}} v</br>
            @endif
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col p-md-0">
            @if (!empty($device->getProperties) && count($device->getProperties) > 0)
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name / Type</th>
                            <th>Last Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($device->getProperties as $property)
                        <tr>
                            <td>
                                {!! form($propertyForms[$property->id]) !!}
                            </td>
                            <td>{{$property->nick_name}} <br> {{$property->type}}</td>
                            <td>
                                @if (!empty($property->last_value))
                                {{round($property->last_value->value, 2)}}
                                @endif
                            </td>
                            <td>
                                <a href="{{route('controls.detail', $property->id)}}" class="btn btn-primary"><i class="fa fa-chart-area"></i></a>
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
    </div>
</div>


{{--
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.devices.devices.pageTitle')}}
</div>
<div class="card-body">

</div>
</div>
</div>
</div>
</br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Diagnostic Information</div>
            <div class="card-body">
                @if (!empty(round($device->created)))
                {{ __('First Seen') }}: {{$device->createdat}}</br>
                @endif
                {{ __('Last Seen') }}: {{$device->heartbeat}}</br>

                {{ __('Ip Address') }}:</br>
                {{ __('Gatevay') }}:</br>
                {{ __('subnet') }}:</br>

                @if (!empty(round($device->signal_strength)))
                {{ __('Signal') }}: {{$device->signal_strength}} %</br>
                @endif
                @if (!empty(round($device->battery_level)))
                {{ __('Battery') }}: {{round($device->battery_level, 2)}} v</br>
                @endif
            </div>
        </div>
    </div>
</div>
</br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('simplehome.deviceList') }}</div>
            <div class="card-body">

                @if (!empty($device->getProperties) && count($device->getProperties) > 0)
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>History</th>
                                <th>Last Value</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($device->getProperties as $property)
                            <tr>
                                <td>
                                    {!! form($propertyForms[$property->id]) !!}
                                </td>
                                <td>{{$property->nick_name}}</td>
                                <td>{{$property->type}}</td>
                                <td>{!! form($historyForms[$property->id]) !!}</td>
                                <td>
                                    @if (!empty($property->last_value))
                                    {{round($property->last_value->value, 2)}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('properties_detail', $property->id) }}" class="btn btn-primary"><i class="fa fa-chart-area"></i></a>
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
        </div>
    </div>
</div>
</br>
</div>
--}}
@endsection