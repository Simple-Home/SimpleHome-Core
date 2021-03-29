@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
    <div class="row row-cols-1 row-cols-md-3">
        <div class="col mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Disk</h5>
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
                <div class="card-body">
                    <h5 class="card-title">CPU</h5>
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
                <div class="card-body">
                    <h5 class="card-title">RAM</h5>
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
                <div class="card-body">
                    <h5 class="card-title">Services</h5>
                    APACHE: <p class="{{ !$services['apache2'] ? 'text-danger' : 'text-success' }}">{{($services["apache2"] ? "Active" : "Notactive")}}</p><br>
                    MYSQL: <p class="{{ !$services['mysql'] ? 'text-danger' : 'text-success' }}">{{($services["mysql"] ? "Active" : "Notactive")}}</p><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
