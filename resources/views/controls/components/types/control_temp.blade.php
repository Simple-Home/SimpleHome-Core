<a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $property->last_value->value + ($property->step_value))])}}" class="h2" title="">
    <i class="fas fa-angle-up"></i>
</a>
{{$property->last_value->value}}
<a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $property->last_value->value - ($property->step_value))])}}" class="h2" title="">
    <i class="fas fa-angle-down"></i>
</a>