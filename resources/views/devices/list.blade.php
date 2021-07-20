@extends('layouts.app')
@section('pageTitle', trans('simplehome.devices.list.pageTitle') )
@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h2>{{ __('simplehome.deviceList') }}</h2>
                    </div>
                    <div class="col">
                        <div class="float-right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeviceModal" title="{{ __('simplehome.addDevice') }}">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($devices) && count($devices) > 0)
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Hostname</th>
                            <th>Token</th>
                            <th>Heartbeat</th>
                            <th>Sleep</th>
                            <th>Signal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                        <tr>
                            <td>{{$device->hostname}}</td>
                            <td>{{$device->token}}</td>
                            <td class="{{ $device->connection_error ? 'text-danger' : 'text-success' }}">{{$device->heartbeat}}</td>
                            <td>{{$device->sleep}} ms</td>
                            <td>{{$device->signal_strength}}%</td>
                            <td>
                                <a href="/test" class="btn btn-primary"><i class="fas fa-upload"></i></a>
                                <a href="/test" class="btn btn-primary"><i class="fas fa-redo"></i></a>
                                @if ($device->approved)
                                <a href="/test" class="btn btn-primary"><i class="fas fa-times"></i></a>
                                @else
                                <a href="/test" class="btn btn-primary"><i class="fas fa-check"></i></a>
                                @endif

                                @if (empty($device->settingsCount > 0))
                                <a href="{{ route('devices_settings', $device->id) }}" class="btn btn-primary"><i class="fas fa-cog"></i></a>
                                @endif

                                <a href="/test" class="btn btn-primary"><i class="fas fa-terminal"></i></a>
                                <a href="{{ route('devices_detail', $device->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center">{{ __('simplehome.noDevices') }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">{{ __('simplehome.addDevice') }}</div>

                <div class="card-body">
                    {!! form($addDeviceForm) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
