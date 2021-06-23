@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
<div class="row">
    <div class="col-md-2">
      @include('settings.components.subnavigation')
    </div>
    <div class="col">
        <div class="row row-cols-1 row-cols-md-3">
            <div class="col mb-4">
                <div class="card">
                    <div class="card-header">{{ __('simplehome.server.disk') }}</div>
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
                    <div class="card-header">{{ __('simplehome.server.cpu') }}</div>
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
                    <div class="card-header">{{ __('simplehome.server.memory') }}</div>
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
                    <div class="card-header">{{ __('simplehome.server.services') }}</div>
                    <div class="card-body">
                        APACHE: <span
                                class="{{ !$services['apache2'] ? 'text-danger' : 'text-success' }}">{{($services["apache2"] ? __('simplehome.server.active')  : __('simplehome.server.inactive'))}}</span><br>
                        MYSQL: <span
                                class="{{ !$services['mysql'] ? 'text-danger' : 'text-success' }}">{{($services["mysql"] ? __('simplehome.server.active') :  __('simplehome.server.inactive'))}}</span><br>
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