<?php $lastValue = isset($property->latestRecord) ? $property->latestRecord->value : 1; ?>
<?php $stepValue = $property->step_setting_value; ?>
<?php $integration = $property->device->integration; ?>

<div class="ms-auto text-center">
    <i class="control-range fas fa-angle-up d-inline me-1" data-control-type="+"></i>
    <input class="range-value  d-inline" maxlength="2" size="1" type="number"
        data-url="{{ route($integration . '.set', ['properti_id' => $property->id, 'value' => 'value']) }}"
        data-control-step="{{ $stepValue }}" value="{{ $lastValue }}" min="{{ $property->min_setting_value }}"
        max="{{ $property->max_setting_value }}"
        onkeypress="this.style.width = ((this.value.length + 1) * 15) + 'px';"
        onchange="this.style.width = ((this.value.length + 1) * 15) + 'px';" />
    <small style="color: #686e73;" class="d-inline">
        {{ $property->units }}
    </small>
    <i class="control-range fas fa-angle-down d-inline ms-1" data-control-type="-"></i>
</div>