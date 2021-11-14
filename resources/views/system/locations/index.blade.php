@extends('layouts.settings')
@section('title', trans('simplehome.locations.page.title'))

@section('customHead')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/css/ol.css"
        type="text/css">
    <style>
        .map {
            height: 400px;
            width: 100%;
        }

    </style>
    <link rel="stylesheet"
        href="{{ asset('css/bootstrap-iconpicker.min.css', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" />
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
        defer></script>
    <script type="text/javascript"
        src="{{ asset('js/bootstrap-iconpicker.bundle.min.js', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        defer></script>
@endsection


@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    @include('components.search')
    <div id="ajax-loader" class="h-100" data-url="{{ route('system.locations.ajax.list') }}">
        <div class="d-flex h-100">
            <div class="text-center m-auto">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="locationCreation" tabindex="-1" aria-labelledby="locationCreation" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.locations.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('beforeBodyEnd')
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/build/ol.js"></script>
    <script
        src="{{ asset(mix('js/locations-controller.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
@endsection
