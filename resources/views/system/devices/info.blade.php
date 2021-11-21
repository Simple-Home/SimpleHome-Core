@extends('layouts.settings')
@section('title', trans('simplehome.devices.info.page.title'))

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <h2>Device</h2>
    <p>
        Integration: <a href="#">{{ $device->integration }}</a><br>
        Approved: {{ $device->approved ? 'True' : 'False'}}<br>
        SleepTime: {{ $device->sleep }}<br>
        Type: {{ $device->type }}<br>
    </p>
    <h2>Properties</h2>
    @foreach ($device->properties as $properti)
        <p>
            NickName: {{ $properti->nick_name}}<br>
            Room: <a href="#">{{ $properti->room->name }}</a><br>
            Type: {{ $properti->type }}<br>
            Disabled: {{ $properti->is_disabled ? 'True' : 'False' }}<br>
            Hidden: {{ $properti->is_hidden ? 'True' : 'False' }}<br>
        </p>
    @endforeach
@endsection
