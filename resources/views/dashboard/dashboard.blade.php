@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(!empty($graphs) && count($graphs) > 0)
            @foreach ($graphs as $graph)
            @if ($graph)
            <div style="heigth:30%;">
                {!! $graph->render() !!}
            </div>
            @endif
            @endforeach
            @endif

            <div class="card">
                <div class="card-header">{{ __('Dashboard 2 ') }}</div>

                <div class="card-body">

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
