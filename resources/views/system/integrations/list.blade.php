@extends('layouts.settings')
@section('title', trans('simplehome.integrations.page.title'))

@section('content')
    <div class="content">
        @if (!empty($integrations) && count($integrations) > 0)
            <div class="row g-2 d-flex">
                @foreach ($integrations as $integration)
                    <div class="col-lg-4 col-md-6 col-12">
                        @include('system.components.integration', $integration)
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center">{{ __('simplehome.noIntegration') }}</p>
        @endif
    </div>
@endsection
