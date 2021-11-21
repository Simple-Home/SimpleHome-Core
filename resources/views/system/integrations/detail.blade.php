@extends('layouts.settings')
@section('title', trans('simplehome.integrations.page.title'))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ __('simplehome.controls') }}
        </div>
        <div class="card-body">
            @include('system.components.controls', $integration)
        </div>
    </div>
    @if (!empty($settings) && count($settings) > 0)
        <div class="card mb-3">
            <div class="card-header">
                {{ __('simplehome.settings') }}
            </div>
            <div class="card-body">
                {!! form($systemSettingsForm) !!}
            </div>
        </div>
    @endif
    @if (!empty($integration["providetDevices"]) && count($integration["providetDevices"]) > 0)
        <div class="card mb-3">
            <div class="card-header">
                {{ __('simplehome.devices') }}
            </div>
            <div class="card-body">
                <div class="row g-2 equal">
                    @foreach ($integration["providetDevices"] as $device)
                        <div class="col-lg-4 col-md-6 col-12 p-0">
                            @include('system.components.device', $device)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
