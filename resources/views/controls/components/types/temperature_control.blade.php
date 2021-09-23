<?php $lastValue = $property->latestRecord->value; ?>
<?php $stepValue = $property->step_value; ?>
<div>
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $lastValue + ((int) $stepValue ))])}}" class="h2" title="">
        <i class="fas fa-angle-up"></i>
    </a>
    {{$lastValue}}
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $lastValue - ((int) $stepValue))])}}" class="h2" title="">
        <i class="fas fa-angle-down"></i>
    </a>
</div>