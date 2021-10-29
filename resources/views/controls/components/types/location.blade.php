@if($property->getLocation() !== false)
    @if(!empty($property->getLocation()->icon))
        <i class="fas {{ $property->getLocation()->icon }}"></i>
    @else
        {{ $property->getLocation()->name }}
    @endif
@else
    <i class="fas fa-location-arrow"></i>
@endif

