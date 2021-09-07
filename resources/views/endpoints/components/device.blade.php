<div class="card p-2 m-1">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2" href="{{ route('endpoints.devices.detail', $device->id) }}">
                    {{$device->hostname}}
                </a>
                <p class="m-0 text-left">
                    {{$device->token}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col m-0">
                @include('endpoints.components.controls', $device)
            </div>
        </div>
    </div>
</div>