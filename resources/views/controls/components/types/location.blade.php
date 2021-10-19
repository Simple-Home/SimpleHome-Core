@if ($property->getLocation())
    {{-- Show Friendly name or Icon --}}
    {{ $property->getLocation() }}
@else
    <i class="fas fa-location-arrow"></i>
@endif
