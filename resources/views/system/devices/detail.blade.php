@extends('layouts.detail')
@section('pageTitle', trans('simplehome.devices.detail.pageTitle'))
@section('content')
    <div class="container p-0">
        <div class="row justify-content-between">
            <div class="col p-md-0">
                <div class="row justify-content-between">
                    <div class="col p-md-0">
                        <a style="font-weight:bold" class="h4 text-decoration-none fw-bold"
                            href="{{ route('system.devices.list') }}"><i class="fas fa-chevron-left me-2"></i>Device</a>
                    </div>
                    <div class="col p-md-0 text-end my-auto">
                        <a style="font-weight:bold" class="h3 fw-bold"
                            href="{{ route('system.devices.edit', $device->id) }}"><i class="fas fa-cog"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col p-md-0">
                <div>
                    <h3 class="mb-0">{{ $device->hostname }}</h3>
                    <p class="mb-0">{{ $device->heartbeat }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col p-md-0">
                <div>Diagnostic Information</div>
                @if (!empty(round($device->created)))
                    {{ __('First Seen') }}: {{ $device->createdat }}</br>
                @endif
                {{ __('Last Seen') }}: {{ $device->heartbeat }}</br>
                {{ __('Ip Address') }}:</br>
                {{ __('Gateway') }}:</br>
                {{ __('subnet') }}:</br>
                @if (!empty(round($device->signal_strength)))
                    {{ __('Signal') }}: {{ $device->signal_strength }} dbm ({{ $device->signal_strength_percent }}
                    %)
                    </br>
                @endif
                @if (!empty(round($device->battery_level)))
                    {{ __('Battery') }}: {{ round($device->battery_level, 2) }} v
                    ({{ round($device->battery_level_percent, 2) }} %)</br>
                @endif
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col p-md-0">
                @if (!empty($device->getProperties) && count($device->getProperties) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Name / Type</th>
                                    <th scope="col">Last Value</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($device->getProperties as $property)
                                    <tr>
                                        <th scope="row">
                                            <i class="fas {{ $property->icon }}"></i>
                                        </th>
                                        <td>{{ $property->nick_name }} <br> {{ $property->type }}</td>
                                        <td>
                                            @if (!empty(($lastRecord = $property->latestRecord)))
                                                {{ !empty($lastRecord->origin) ? $lastRecord->origin . '->' : '' }}{{ round($lastRecord->value, 2) }}
                                                {{ $property->units }}
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('controls.detail', $property->id) }}"
                                                class="btn btn-primary"><i class="fa fa-chart-area"></i></a>
                                            <a href="{{ route('controls.edit', $property->id) }}"
                                                class="btn btn-primary"><i class="fa fa-cog"></i></a>
                                            <a href="{{ route('controls.remove', $property->id) }}"
                                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
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


    {{-- <div class="container">
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
                                    @if (!empty($property->latestRecord))
                                    {{round($property->latestRecord->value, 2)}}
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
</div> --}}
@endsection
