<div class="card p-2 m-1">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2" href="{{ route('system.devices.detail', $device->id) }}">
                    {{$device->hostname}}
                </a>
                <p class="m-0 text-left">
                    {{__('properties.count') . ': ' . $device->getProperties->count()}}
                </p>
                @if(!empty($device->heartbeat))
                <p class="m-0 text-left {{ $device->offline ? 'text-danger' : 'text-success'  }}">
                    {{__('properties.count') . ': ' . $device->heartbeat->diffForHumans()}}
                </p>
                @else<p class="m-0 text-left text-danger">
                    offline
                </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col m-0">
                <div class="d-flex justify-content-between">
                    @include('system.components.device_controls', $device)
                </div>
            </div>
        </div>
    </div>
</div>