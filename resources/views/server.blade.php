@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
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
                    APACHE: <p class="{{ !$services['apache2'] ? 'text-danger' : 'text-success' }}">{{($services["apache2"] ? "Active" : "Notactive")}}</p><br>
                    MYSQL: <p class="{{ !$services['mysql'] ? 'text-danger' : 'text-success' }}">{{($services["mysql"] ? "Active" : "Notactive")}}</p><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
