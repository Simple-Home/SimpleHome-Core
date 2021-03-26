@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Server Dashboard') }}</div>
                <div class="card-body">
                    TIMEZONE: {{$server_info["timezone"]}} <br>
                    CPU: {{$server_info["cpu"]}} <br>
                    RAM: {{$server_info["ram"]["used"]}} / {{$server_info["ram"]["total"]}} <br>
                    APACHE: {{($server_info["services"]["apache2"] ? "Active" : "Notactive")}} <br>
                    MYSQL: {{($server_info["services"]["apache2"] ? "Active" : "Notactive")}} <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
