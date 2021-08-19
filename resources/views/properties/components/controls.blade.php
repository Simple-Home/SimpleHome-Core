@if (!empty($property->last_value->value) && ($property->type == "switch"))
@if (strtolower($property->last_value->value) == "off")
<button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'state', 'on');" class="btn btn-success">Turn On</button>
<a href="{{-- route('device.control', [$device->hostname, "state", "ON"]) --}}" title="On" class="btn btn-primary"><i class="fas fa-power-off"></i></a>
@else
<button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'state', 'off');" class="btn btn-danger">Turn Off</button>
<a href="{{-- route('device.control', [$device->hostname, "state", "OFF"]) --}}" title="Off" class="btn btn-danger"><i class="fas fa-power-off"></i></a>
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