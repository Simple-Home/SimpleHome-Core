@extends('layouts.app')
@section('title', trans('simplehome.automations.pageTitle'))

@section('subnavigation')
    @include('automations.components.subnavigation')
@endsection

@section('content')
    <div id="carouselExampleSlidesOnly" class="carousel slide h-100" data-bs-wrap="false" data-bs-keyboard="true"
        data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="false">
        <div class="carousel-inner h-100">
            @foreach (['automations', 'scenes'] as $type)
                <div class="carousel-item h-100" data-automation-type="{{ $type }}"
                    data-url="{{ route('automations.ajax.list', ['type' => $type]) }}">
                    <div class="d-flex h-100">
                        <div class="text-center m-auto">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <!-- TODO:Načítat AJAXEM -->
    <div class="modal" id="automatonForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="automatonFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('simplehome.automations.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <div class="position-relative m-4">
                                        <div class="progress" style="height: 1px;">
                                            <div class="progress-bar" role="progressbar" style="width: 100%;"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <button type="button"
                                            class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill"
                                            style="width: 2rem; height:2rem;">1</button>
                                        <button type="button"
                                            class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-primary rounded-pill"
                                            style="width: 2rem; height:2rem;">2</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="automation-content">
                            <div class="row">
                                <div class="col mb-3">
                                    <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start"
                                        data-url="{{ route('automations.tasks') }}" data-automation-type="manual">
                                        <i class="fas fa-toggle-on pr-2 me-2" aria-hidden="true"></i>Manual
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="btn-group-vertical  w-100">
                                        <button type="button"
                                            class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                                            data-url="#">
                                            <i class="fas fa-cloud-sun pr-2 me-2" aria-hidden="true"></i>Weather
                                        </button>
                                        <button type="button"
                                            class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                                            data-url="#">
                                            <i class="fas fa-map-marker pr-2 me-2" aria-hidden="true"></i>Location
                                        </button>
                                        <button type="button"
                                            class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                                            data-url="#">
                                            <i class="fas fa-hourglass-half pr-2 me-2" aria-hidden="true"></i>Schedule
                                        </button>
                                        <button type="button"
                                            class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                                            data-url="#">
                                            <i class="fas fa-sync pr-2 me-2" aria-hidden="true"></i>Device Status Change
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('modal-footer')
            </div>
        </div>
    </div>
@endsection


@section('beforeBodyEnd')
    <script>
        $('body').on('click', 'button.automation-type', function(e) {
            thisObj = $(this);
            console.log(thisObj.data("url"));
            thisObj.html("<div class=\"spinner-border text-primary\" role=\"status\"></div>");
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    type: thisObj.data("automation-type")
                },
                type: 'GET',
                url: thisObj.data("url"),
                success: function(msg) {
                    $('div.automation-content').replaceWith(msg);
                }
            });
        });
    </script>
@endsection
