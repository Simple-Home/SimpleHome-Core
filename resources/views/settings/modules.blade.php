@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.components.subnavigation')
        </div>
        <div class="col">
            @if(!empty($modulesList) && count($modulesList) > 0)
            <div class="col">
                <div class="row row-cols-1 row-cols-md-3">
                    @foreach ($modulesList as $module)
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('modules_detail', strtolower($module)) }}">
                                    {{ $module }}
                                </a>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
                <p class="text-center">{{ __('No Modules Found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection