@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Users List') }}</div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Hostname</th>
                                <th scope="col">Email</th>
                                <th scope="col">MFA</th>
                                <th scope="col">Permission</th>
                                <th scope="col"></th>
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
            </div>
        </div>
    </div>
</div>
@endsection
