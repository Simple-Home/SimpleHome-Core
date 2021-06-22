@if (!empty($property->last_value->value) && ($property->type == "switch"))
    @if (strtolower($property->last_value->value) == "off")
        <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'state', 'on');" class="btn btn-success">Turn On</button>
    @else
        <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'state', 'off');" class="btn btn-danger">Turn Off</button>
    @endif
@endif

@if (strtolower($property->type) == "light")
    <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'brightness', '10');" class="btn btn-primary">Max Brightness</button>
    &nbsp;
    <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'brightness', '1');" class="btn btn-primary">Min Brightness</button>
@endif

@if (strtolower($property->type) == "speaker")
    <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'volume', '10');" class="btn btn-primary">Max Volume</button>
    &nbsp;
    <button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'volume', '1');" class="btn btn-primary">Min Volume</button>
@endif