@extends('layouts.app')
@section('title', 'dev')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div id="ajax-loader" class="h-100" data-url="{{ route('system.developments.ajax.list') }}">
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
    <!-- TODO: REDO TO LOAD BY AJAX SAME LIKE IN LOCATIONS -->
    <div class="modal fade" id="personalAccessTokenCreation" tabindex="-1" aria-labelledby="personalAccessTokenCreation"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Personal Access Token</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="private-token" class="">
                    <div class="modal-body">
                        <div class="col-auto">
                            <label for="tokenName" class="visually-hidden">Password</label>
                            <input type="text" class="form-control" name="tokenName" id="tokenName"
                                placeholder="Token Name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('beforeBodyEnd')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script
        src="{{ asset(mix('js/developments-controller.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script>
        $(function() {
            $('form#private-token').on('submit', function(e) {
                var form = $('form#private-token');
                console.log(form.serialize())
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route('system.developments.personnal.ajax.new') }}',
                    data: form.serialize(),
                    success: function(msg) {
                        var responseWraper =
                            "<div class=\"modal-body\"> \
                                                                                <code id=\"accessToken\">" +
                            msg +
                            "</code> \
                                                                                <button class=\"btn\" data-clipboard-target=\"#accessToken\">\
                                                                                    <i class=\"fas fa-paperclip\"></i>\
                                                                                </button>\
                                                                            </div> \
                                                                            <div class=\"modal-footer\"> \
                                                                                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button> \
                                                                            </div>"
                        form.replaceWith(responseWraper);
                    }
                });
                e.preventDefault();
            });
        });
    </script>
@endsection
