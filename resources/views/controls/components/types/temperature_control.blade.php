<?php $lastValue = isset($property->latestRecord) ? $property->latestRecord->value : 1; ?>
<?php $stepValue = $property->step_setting_value; ?>
<?php $integration = $property->device->integration; ?>

<div class="ms-auto d-inline text-center">
    <div class="h2 control-range m-0" data-control-type="+">
        +
    </div>
    <input class="range-value" type="number"
        data-url="{{ route($integration . '.set', ['properti_id' => $property->id, 'value' => 'value']) }}"
        data-control-step="{{ $stepValue }}" value="{{ $lastValue }}" min="0" max="99" />
    <div class="h2 control-range  m-0" data-control-type="-">
        -
    </div>
</div>
