<div class="card p-2 m-1">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2" href="{{ route('system.integrations.detail', strtolower($integration['name'])) }}">
                    {{$integration["name"]}}
                </a>
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