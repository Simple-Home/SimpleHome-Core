@extends('layouts.app')

@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        @if(!empty($users) && count($users) > 0)
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <h2>{{ __('Users List') }}</h2>
                </div>
                <div class="col">
                    <div class="float-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th scope="col">Hostname</th>
                        <th>Email</th>
                        <th>MFA</th>
                        <th>Permission</th>
                        <th style="width: 25%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->MFA}}</td>
                        <td>{{$user->Permission}}</td>
                        <td><a href="{{ route('user.delete') }}" class="btn btn-danger"><i class="fas fa-times"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center">{{ __('Nothing Found') }}</p>
        @endif
    </div>
</div>
@endsection
