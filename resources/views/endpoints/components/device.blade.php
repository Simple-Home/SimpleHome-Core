<div class="card p-2 m-1" style="height: 100px">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2" href="{{ route('endpoints.devices.detail', $device->id) }}">
                    {{$device->hostname}}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col m-0">
                <p class="m-0">
                    <td>{{$device->token}}</td>
                </p>
            </div>
        </div>
    </div>
</div>