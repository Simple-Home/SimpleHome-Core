<div>
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $property->latestRecord->value + ((int)$property->step_value))])}}" class="h2" title="">
        <i class="fas fa-angle-up"></i>
    </a>
    {{$property->latestRecord->value}}
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $property->latestRecord->value - ((int) $property->step_value))])}}" class="h2" title="">
        <i class="fas fa-angle-down"></i>
    </a>
</div>