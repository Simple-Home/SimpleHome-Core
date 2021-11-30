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
                        <div class="automation-content">

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
        $('body').on('click', '[data-form-url]', function(event) {
            thisObj = $(this);
            console.log("[ajaxAction]-start");
            console.log("[ajaxAction]-source", thisObj);
            console.log("[ajaxAction]-url:", thisObj.data("[formUrl]"));
            event.preventDefault();

            $('#' + thisObj.data("formId")).modal('show');
            ajaxContentLoader($('#' + thisObj.data("formId")).find(".automation-content"), thisObj.data("formUrl"),
                true, "GET");

            event.stopPropagation();
            console.log("[ajaxAction]-finish");
        });
    </script>
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
                type: 'POST',
                url: thisObj.data("url"),
                success: function(msg) {
                    $('div.automation-content').replaceWith(msg);
                }
            });
        });
    </script>
    <script>
        $('#automatonForm').on('hidden.bs.modal', function(e) {
            ajaxContentLoader($('#automatonForm').find(".automation-content"),
                "{{ route('automations.form.load') }}",
                true, "GET");
        })
        $('#automatonForm').on('show.bs.modal', function(e) {
            ajaxContentLoader($('#automatonForm').find(".automation-content"),
                "{{ route('automations.form.load') }}",
                true, "GET", true);
        })
    </script>
    <script src="{{ asset(mix('js/automations.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
@endsection
