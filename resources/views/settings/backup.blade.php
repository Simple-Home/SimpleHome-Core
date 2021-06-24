@extends('layouts.app')
@section('customHead')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @livewireStyles
@endsection
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @livewireScripts
@endsection