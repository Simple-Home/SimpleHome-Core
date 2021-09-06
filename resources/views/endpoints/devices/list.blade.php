@extends('layouts.app')
@section('title', trans('simplehome.endpoint.panelTitle'))

@section('subnavigation')
@include('endpoints.components.subnavigation')
@endsection

@section('content')
@if(!empty($devices) && count($devices) > 0)
@foreach ($devices as $device)
@include('endpoints.components.device', $device)
@endforeach
@else
<p class="text-center">{{ __('simplehome.noDevices') }}</p>
@endif
@endsection



{{--
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
            <tr data-toggle="collapse" data-target="#device-{{$device->id}}" class="accordion-toggle">
<td>{{$device->hostname}}</td>
<td>{{$device->token}}</td>
<td class="{{ $device->connection_error ? 'text-danger' : 'text-success' }}">{{$device->heartbeat}}</td>
<td>{{$device->sleep}} ms</td>
<td>{{$device->signal_strength}}%</td>
<td>
    <a href="{{ route('devices_detail', $device->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

    @if ($device->type == "0" || $device->type == "other")
    <a href="/test" class="btn btn-primary"><i class="fas fa-upload"></i></a>
    <a href="/test" class="btn btn-primary"><i class="fas fa-redo"></i></a>
    <a href="/test" class="btn btn-primary"><i class="fas fa-terminal"></i></a>
    @endif

    @if ($device->settingsCount > 0)
    <a href="{{ route('devices_settings', $device->id) }}" class="btn btn-primary"><i class="fas fa-cog"></i></a>
    @endif

    @if ($device->approved)
    <a href="/test" class="btn btn-primary"><i class="fas fa-times"></i></a>
    @else
    <a href="/test" class="btn btn-primary"><i class="fas fa-check"></i></a>
    @endif
</td>
</tr>
@if (!empty($properties = $device->getProperties))
@endif
@endforeach
</tbody>
</table>
</div>
@else
<p class="text-center">{{ __('simplehome.noDevices') }}</p>
@endif
@endsection
--}}