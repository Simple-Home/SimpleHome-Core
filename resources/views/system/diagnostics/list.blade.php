@extends('layouts.app')
@section('title', 'Diagnostics')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div id="server-dashboard" data-chart-endpoint="{{route('system.diagnostics.chart.data')}}" class="container">
    <div class="row">
        <div class="col">
            <div class="row ">
                <div class="col-2 ml-auto">
                    <div class="form-group">
                        <label for="refresh-chart">{{__('simplehome.server.refreshChart')}}</label>
                        <select class="form-control" id="refresh-chart">
                            <option value="1">1 {{__('simplehome.seconds')}}</option>
                            <option value="5" selected>5 {{__('simplehome.seconds')}}</option>
                            <option value="10">10 {{__('simplehome.seconds')}}</option>
                            <option value="30">30 {{__('simplehome.seconds')}}</option>
                            <option value="60">1 {{__('simplehome.minutes')}}</option>
                            <option value="120">2 {{__('simplehome.minutes')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.disk') }}</div>
                        <div class="card-body">
                            <div data-spinner="disk-spinner" class="text-center" id="server-disk-chart">
                                <div id="disk-spinner" class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.cpu') }}</div>
                        <div class="card-body">
                            <div data-spinner="cpu-spinner" class="text-center" id="server-cpu-chart">
                                <div id="cpu-spinner" class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.memory') }}</div>
                        <div class="card-body">
                            <div data-spinner="memory-spinner" class="text-center" id="server-memory-chart">
                                <div id="memory-spinner" class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.services') }}</div>
                        <div class="card-body">
                            APACHE: <span class="{{ !$services['apache2'] ? 'text-danger' : 'text-success' }}">{{($services["apache2"] ? __('simplehome.server.active')  : __('simplehome.server.inactive'))}}</span><br>
                            MYSQL: <span class="{{ !$services['mysql'] ? 'text-danger' : 'text-success' }}">{{($services["mysql"] ? __('simplehome.server.active') :  __('simplehome.server.inactive'))}}</span><br>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.connectivity') }}</div>
                        <div class="card-body">
                            {{ __('simplehome.publicIp') }}: <a href="https://{{$services["public_ip"]}}">{{$services["public_ip"]}}</a><br>
                            {{ __('simplehome.networkIp') }}: <a href="https://{{$services["internal_ip"]}}">{{$services["internal_ip"]}}</a><br>
                            {{ __('simplehome.hostname') }}: <a href="https://{{$services["hostname"]}}">{{$services["hostname"]}}</a><br>
                            SSL: <span class="{{ !$ssl ? 'text-danger' : 'text-success' }}">{{($ssl ? __('simplehome.server.sslOn'): __('simplehome.server.sslOff'))}}</span><br>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-header">{{ __('simplehome.server.metrics') }}</div>
                        <div class="card-body">
                            {{ __('simplehome.server.valuePerMinute') }}: {{$valuesPerMinute}}<br>
                            {{ __('simplehome.server.uptime') }}: {{$uptime}}<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection