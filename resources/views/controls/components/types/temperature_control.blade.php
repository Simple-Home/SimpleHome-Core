<?php $lastValue = (isset($property->latestRecord) ? $property->latestRecord->value : 1); ?>
<?php $stepValue = $property->step_value; ?>
<div>
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $lastValue + ((int) $stepValue ))])}}" class="h2 text-decoration-none" title="">
        <i class="fas fa-angle-up"></i>
    </a>
    {{$lastValue}}
    <a href="{{route('properties_set', ['properti_id' => $property->id,'value' => ((int) $lastValue - ((int) $stepValue))])}}" class="h2 text-decoration-none" title="">
        <i class="fas fa-angle-down"></i>
    </a>
</div>