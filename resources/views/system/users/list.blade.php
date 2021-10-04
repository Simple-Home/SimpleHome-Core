@extends('layouts.app')
@section('title', 'users')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
@include('components.search')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">{{ __('simplehome.users.list.pageTitle') }}
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userCreation" title="{{ __('simplehome.users.create') }}">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <div class="card-body">
        @if(!empty($users) && count($users) > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th scope="col">{{__('simplehome.hostname')}}</th>
                        <th>{{__('simplehome.email')}}</th>
                        <th>{{__('simplehome.mfa')}}</th>
                        <th>{{__('simplehome.permissions')}}</th>
                        <th>{{__('simplehome.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                        <td>{{$user->MFA}}</td>
                        <td>{{$user->Permission}}</td>
                        <td><a href="{{ route('system.users.remove', ['user_id' => $user->id]) }}" class="btn btn-danger" title="{{__('simplehome.users.delete')}}"><i class="fas fa-times"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center">{{__('simplehome.users.notFound')}}</p>
        @endif
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="userCreation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! form($userForm) !!}
            </div>
        </div>
    </div>
</div>
@if (count($errors) > 0)
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script>
        $( document ).ready(function() {
            $('#userCreation').modal('show');
        });
    </script>
@endif
@endsection