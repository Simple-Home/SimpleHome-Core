@extends('layouts.settings')
@section('title', 'simplehome.env.variables')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('simplehome.profile.jobs') }}</div>
        <div class="card-body">
            {!! form($systemEnvSettingsForm) !!}
        </div>
    </div>
@endsection
