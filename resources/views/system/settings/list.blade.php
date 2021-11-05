@extends('layouts.settings')
@section('title', 'HOME')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')

    @if (!empty($settings) && count($settings) > 0)
        <div class="card">
            <div class="card-header">{{ __('simplehome.profile.szstem.settings') }}</div>
            <div class="card-body">
                {!! form($systemSettingsForm) !!}
            </div>
        </div>
    @else
        <p class="text-center">{{ __('No System Settings Found') }}</p>
    @endif

@endsection
