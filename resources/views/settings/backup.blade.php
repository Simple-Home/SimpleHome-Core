@extends('layouts.app')
@section('customHead')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @livewireStyles
@endsection
@section('pageTitle', trans('simplehome.backup.panelTitle') )
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-2">
                @include('settings.components.subnavigation')
            </div>
            <div class="col-12 col-md-10">
                <div class="row">
                    <livewire:laravel_backup_panel::app/>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('beforeBodyEnd')
    @livewireScripts
@endsection