@extends('layouts.app')
@section('title', 'dev')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">{{__('simplehome.oauth.clients')}}
        <button class="btn btn-primary">Create new {{__('simplehome.oauth.clients')}}</button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Client ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Secret</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($authorizedClients as $client)
                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td><code class="text-break">{{$client->secret}}</code></td>
                    <td>
                        <a class="btn bg-info" href="btn" role="button">Edit</a>
                        <a class="btn btn-danger" href="btn" role="button">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">{{__('simplehome.oauth.authorized.apps')}}

    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Scope</th>
                    <th scope="col">expire</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($authenticatedApps as $token)
                <tr>
                    <td>{{$token->client->name}}</td>
                    <td>{{$token->scope}}</td>
                    <td>{{$token->expires_at}}</td>
                    <td>
                        @if(!$token->revoked)
                        <a class="btn btn-danger" href="btn" role="button">Revoke</a>
                        @else
                        Revoked
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">{{__('simplehome.oauth.personal.access.tokens')}}
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#personalAccessTokenCreation">Create new {{__('simplehome.oauth.authorized.apps')}}</button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Scope</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($personalTokens as $personalAccessToken)
                <tr>
                    <td>{{$personalAccessToken->name}}</td>
                    <td>{{$personalAccessToken->scope}}</td>
                    <td>{{$personalAccessToken->jwt}}</td>

                    <td>
                        @if(!$personalAccessToken->revoked)
                        <a class="btn btn-danger" href="btn" role="button">Revoke</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="personalAccessTokenCreation" tabindex="-1" aria-labelledby="personalAccessTokenCreation" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Personal Access Token</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="private-token" class="">
                <div class="modal-body">
                    <div class="col-auto">
                        <label for="tokenName" class="visually-hidden">Password</label>
                        <input type="text" class="form-control" name="tokenName" id="tokenName" placeholder="Token Name" required>
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
<script src="dist/clipboard.min.js"></script>
<script>
    $(function() {
        $('form#private-token').on('submit', function(e) {
            var form = $('form#private-token');
            console.log(form.serialize())
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{route("system.developments.ajax.private.token")}}',
                data: form.serialize(),
                success: function(msg) {
                    var responseWraper = "<div class=\"modal-body\"> \
                                            <code id=\"accessToken\">" + msg + "</code> \
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
        });
    });
</script>
@endsection