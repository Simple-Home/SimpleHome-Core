@extends('layouts.settings')
@section('title', 'maintenance')

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('simplehome.profile.informations') }}</div>
        <div class="card-body">
            <form action="{{ route('system.housekeepings.save') }}" method="post">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input bg-light" name="housekeeping_active" type="checkbox" value="1"
                            id="active" @if ($settings['active']->value != 0) checked="checked" @endif>
                        <label class="form-check-label" for="active">
                            {{ __('simplehome.active') }}
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="interval">{{ __('simplehome.housekeeping.interval') }}</label>
                    <input type="number" name="housekeeping_interval" class="form-control" id="interval"
                        value="{{ $settings['interval']->value }}" placeholder="Number of days">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input bg-light" name="housekeeping_logs_cleaning_active" type="checkbox"
                            value="1" id="active" @if ($settings['logs_cleaning_active']->value != 0) checked="checked" @endif>
                        <label class="form-check-label" for="active">
                            {{ __('simplehome.active') }}
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="interval">{{ __('simplehome.housekeeping.log.interval') }}</label>
                    <input type="number" name="housekeeping_logs_cleaning_interval" class="form-control" id="interval"
                        value="{{ $settings['logs_cleaning_interval']->value }}" placeholder="Number of seconds">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">{{ __('simplehome.save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">{{ __('simplehome.profile.jobs') }}</div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col text-end">
                    {{ __('simplehome.records') }}: {{ $totalRecords }}
                </div>
                <div class="col-auto">
                    <a href="{{ route('system.housekeepings.records.run') }}">
                        <button type="button"
                            class="w-100 btn btn-primary">{{ __('simplehome.housekeeping.runJob') }}</button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    {{ __('simplehome.logs.size') }}: {{ $totalLogsSize }}
                </div>
                <div class="col-auto">
                    <a href="{{ route('system.housekeepings.logs.run') }}">
                        <button type="button"
                            class="w-100 btn btn-primary">{{ __('simplehome.housekeeping.logs.runJob') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
