@extends('layouts.settings')
@section('title', 'profile')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="card">
        <div class=" card-header">{{ __('simplehome.pwa') }}</div>
        <div class="card-body">
            <button type="button" onclick="navigator.serviceWorker.controller.postMessage({ action: 'refreshCache'});"
                class="btn btn-primary">Delete local Cache </button>
        </div>
    </div>

    <div class="nav-bar-padding"></div>
@endsection
