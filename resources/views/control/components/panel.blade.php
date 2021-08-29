@if (strtolower($property->type) == "light")
<button type="button" onclick="deviceControl('{{ $property->device->hostname }}', '{{ $property->id }}', 'brightness', '10');" class="btn btn-primary">Max Brightness</button>
@endif