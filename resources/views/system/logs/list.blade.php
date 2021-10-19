@extends('layouts.app')
@section('title', 'Diagnostics')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="panel alert alert-danger">
                <i class="fas fa-exclamation mr-3"></i>
                <b class="d-none d-md-inline">ERROR</b>
                {{ $logsStats['ERROR'] }}
            </div>
        </div>
        <div class="col">
            <div class="panel alert alert-warning">
                <i class="fas fa-exclamation mr-3"></i>
                <b class="d-none d-md-inline">WARNING</b>
                {{ $logsStats['WARNING'] }}
            </div>
        </div>
        <div class="col">
            <div class="panel alert alert-info">
                <i class="fas fa-exclamation mr-3"></i>
                <b class="d-none d-md-inline">EXEPTION</b>
                {{ $logsStats['EXEPTION'] }}
            </div>
        </div>
        <div class="col">
            <div class="panel alert alert-secondary">
                <i class="fas fa-info mr-3"></i>
                <b class="d-none d-md-inline">INFO</b>
                {{ $logsStats['INFO'] }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {!! form($logForm) !!}
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if (!empty($content))
                <pre class="bg-secondary" style="overflow: auto;">
            {{ $content }}
            </pre>
            @endif
        </div>
    </div>
@endsection
