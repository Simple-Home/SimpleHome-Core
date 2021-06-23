@extends('layouts.app')
@section('pageTitle', trans('simplehome.devices.detail.pageTitle') )
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('simplehome.devices.devices.pageTitle')}}</div>
                <div class="card-body">
                    {!! form($deviceForm) !!}
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
                    {{ __('First Seen') }}: {{$device->created}}</br>
                    {{ __('Last Seen') }}: {{$device->heartbeat}}</br>

                    {{ __('Ip Address') }}:</br>
                    {{ __('Gatevay') }}:</br>
                    {{ __('subnet') }}:</br>

                    {{ __('Signal') }}: {{$device->signal_strength}} %</br>
                    {{ __('Battery') }}: {{$device->battery_level}} v</br>

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
                                        <td>
                                            @if (!empty($property->last_value))
                                            {{$property->last_value->value}}
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
<script type="text/javascript" src="{{ asset('js/bootstrap-Iconspicker-laravel.js') }}" defer>
</script>
@endsection
