@extends('layouts.app')

@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($devices) && count($devices) > 0)
            <div class="card">
                <div class="card-header">{{ __('Device List') }}</div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Hostname</th>
                                <th scope="col">Token</th>
                                <th scope="col">Heartbeat</th>
                                <th scope="col">Sleep</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $device)
                            <tr>
                                <td>{{$device->hostname}}</td>
                                <td>{{$device->token}}</td>
                                <td class="{{ $device->connection_error ? 'text-danger' : 'text-success' }}">{{$device->heartbeat}}</td>
                                <td>{{$device->sleep}} ms</td>
                                <td>
                                    <a href="/test" class="btn btn-primary"><i class="fas fa-upload"></i></a>
                                    <a href="/test" class="btn btn-primary"><i class="fas fa-redo"></i></a>
                                    @if ($device->approved)
                                    <a href="/test" class="btn btn-primary"><i class="fas fa-times"></i></a>
                                    @else
                                    <a href="/test" class="btn btn-primary"><i class="fas fa-check"></i></a>
                                    @endif
                                    <a href="/test" class="btn btn-primary"><i class="fas fa-cog"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <p class="text-center">{{ __('Nothing Found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
