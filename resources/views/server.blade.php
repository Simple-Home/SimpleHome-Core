@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <h2>{{ __('Server') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3">
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('Disk') }}</div>
                <div class="card-body">
                    @if ($chartDisk)
                    <div>
                        {!! $chartDisk->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('CPU') }}</div>
                <div class="card-body">
                    @if ($chartCpu)
                    <div>
                        {!! $chartCpu->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('RAM') }}</div>
                <div class="card-body">
                    @if ($chartRam)
                    <div>
                        {!! $chartRam->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('Services') }}</div>
                <div class="card-body">
                    APACHE: <span class="{{ !$services['apache2'] ? 'text-danger' : 'text-success' }}">{{($services["apache2"] ? "Active" : "Not Active")}}</span><br>
                    MYSQL: <span class="{{ !$services['mysql'] ? 'text-danger' : 'text-success' }}">{{($services["mysql"] ? "Active" : "Not Active")}}</span><br>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('Connectivity') }}</div>
                <div class="card-body">
                    Public IP: <a href="https://{{$services["public_ip"]}}">{{$services["public_ip"]}}</a><br>
                    Internal IP: <a href="https://{{$services["internal_ip"]}}">{{$services["internal_ip"]}}</a><br>
                    Hostname: <a href="https://{{$services["hostname"]}}">{{$services["hostname"]}}</a><br>
                    SSL: <span class="{{ !$ssl ? 'text-danger' : 'text-success' }}">{{($ssl ? "on" : "off")}}</span><br>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card">
                <div class="card-header">{{ __('Metrics') }}</div>
                <div class="card-body">
                    values/minute: {{$valuesPerMinute}}<br>
                    Uptime: {{$uptime}}<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
