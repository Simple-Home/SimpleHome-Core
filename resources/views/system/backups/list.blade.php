@extends('layouts.app')
@section('title', 'backups')

@section('customHead')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@livewireStyles
@endsection


@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="row">
                <livewire:laravel_backup_panel::app />
            </div>
        </div>
    </div>
</div>
@endsection

@section('beforeBodyEnd')
@livewireScripts
@endsection