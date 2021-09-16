@extends('layouts.app')
@section('title', 'dev')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container p-0">
    <div class="row pb-2">
        <div class="col p-0">
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
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$client->id}}</td>
                                <td>{{$client->name}}</td>
                                <td><code>{{$client->secret}}</code></td>
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
        </div>
    </div>
    <div class="row pb-2">
        <div class="col p-0">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">{{__('simplehome.oauth.authorized.apps')}}
                    <button class="btn btn-primary">Create new {{__('simplehome.oauth.authorized.apps')}}</button>
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
                            @foreach($tokens as $token)
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
        </div>
    </div>
    <div class="row pb-2">
        <div class="col p-0">
            <div class="card">
                <div class="card-header">{{__('simplehome.oauth.personal.access.tokens')}}</div>
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
                            @foreach($authenticatedApps as $authenticatedApp)
                            <tr>
                                <td>{{$authenticatedApp->name}}</td>
                                <td>{{$authenticatedApp->scope}}</td>
                                <td>
                                    @if(!$authenticatedApp->revoked)
                                    <a class="btn btn-danger" href="btn" role="button">Revoke</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection