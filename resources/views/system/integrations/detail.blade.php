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
@endsection
