@if (isset($property->last_value->value) && is_numeric($property->last_value->value))
<button class="relay h2" data-url="{{route($property->device->integration .'.set', ['properti_id' => $property->id,'value' => ((int) !$property->last_value->value)])}}">
    @if ($property->last_value->value == 1)
    <i class="fas fa-toggle-on"></i>
    @else
    <i class="fas fa-toggle-off"></i>
    @endif
</button>
@else
<button data-url="{{route($property->device->integration .'.set', ['properti_id' => $property->id,'value' => ((int) 1)])}}">
    <i class="fas fa-toggle-off"></i>
</button>
@endif