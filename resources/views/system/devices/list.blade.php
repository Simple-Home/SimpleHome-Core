@extends('layouts.settings')
@section('title', trans('simplehome.devices.page.title'))

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    @include('components.search')
    @if (!empty($devices) && count($devices) > 0)
        <div class="row g-2 equal">
            @foreach ($devices as $device)
                <div class="col-lg-4 col-md-6 col-12 p-0">
                    @include('system.components.device', ['device' => $device])
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">{{ __('simplehome.noDevices') }}</p>
    @endif
@endsection
