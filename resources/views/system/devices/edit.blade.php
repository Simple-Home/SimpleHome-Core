@extends('layouts.detail')

@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <a style="font-weight:bold" class="h4 fw-bold" href="{{route('system.devices.detail', $device->id)}}">Detail</a>
            {!! form($deviceForm) !!}
            <div class="mt-3">
                <a href="{{route('system.devices.remove', $device->id)}}" class="btn btn-danger btn-block">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection