<div class="card p-2 m-1 h-100">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2 text-decoration-none"
                    href="{{ route('system.integrations.detail', strtolower($integration['name'])) }}">
                    {{ $integration['name'] }}
                </a>
                @if ($integration['providetDevices'] > 0)
                    <p>{{ __('simplehome.integrations.devices') }} {{ $integration['providetDevices'] }}</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col m-0">
                <div class="d-flex justify-content-between">
                    @include('system.components.controls', $integration)
                </div>
            </div>
        </div>
    </div>
</div>
