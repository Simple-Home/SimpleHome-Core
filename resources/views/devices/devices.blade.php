@extends('layouts.app')
@section('pageTitle', trans('simplehome.devices.devices.pageTitle') )
@section('content')
<div class="container">
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2>{{ __('Dashboard') }}</h2>
                        </div>
                        <div class="col">
                            <div class="float-right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    {{ __('Add Room') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
