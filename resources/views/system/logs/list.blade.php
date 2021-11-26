@extends('layouts.settings')
@section('title', __('simplehome.logs'))

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')
    <div class="card  d-flex justify-content-between align-items-center mb-3 pt-3">
        <div class="row w-100">
            <div class="col">
                <div class="panel alert alert-danger">
                    <i class="fas fa-exclamation"></i>
                    <b class="d-none d-md-inline">ERROR</b>
                    {{ $logsStats['ERROR'] }}
                </div>
            </div>
            <div class="col">
                <div class="panel alert alert-warning">
                    <i class="fas fa-exclamation"></i>
                    <b class="d-none d-md-inline">WARNING</b>
                    {{ $logsStats['WARNING'] }}
                </div>
            </div>
            <div class="col">
                <div class="panel alert alert-info">
                    <i class="fas fa-exclamation"></i>
                    <b class="d-none d-md-inline">EXEPTION</b>
                    {{ $logsStats['EXEPTION'] }}
                </div>
            </div>
            <div class="col">
                <div class="panel alert alert-secondary">
                    <i class="fas fa-info"></i>
                    <b class="d-none d-md-inline">INFO</b>
                    {{ $logsStats['INFO'] }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            {{ __('simplehome.logs') }}
        </div>
        <div class="card-body">
            <div class="row pb-3">
                <div class="col">
                    {!! form($logForm) !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if (!empty($content))
                        <div class="bg-secondary">
                            @php echo $content @endphp
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection


{{-- <div class="row">
        <div class="col-5">
            @if (!empty($content))
                <div class="bg-secondary">
                    @php echo $content @endphp
                </div>
            @endif
        </div>

    </div> --}}
