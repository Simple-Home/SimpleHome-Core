@if (isset($property->last_value->value) && is_numeric($property->last_value->value))
<a href="{{route($property->device->integration .'.set', ['properti_id' => $property->id,'value' => ((int) !$property->last_value->value)])}}" class="h2" title="">
    @if ($property->last_value->value == 1)
    <i class="fas fa-toggle-on"></i>
    @else
    <i class="fas fa-toggle-off"></i>
    @endif
</a>
@else
<a href="{{route($property->device->integration .'.set', ['properti_id' => $property->id,'value' => 1])}}" class="h2" title="">
    <i class="fas fa-toggle-off"></i>
</a>
@endif