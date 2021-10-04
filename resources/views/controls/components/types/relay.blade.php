<?php
$integration = $property->device->integration;
?>
@if (isset($property->latestRecord->value))
<?php $lastValue = $property->latestRecord->value; ?>
<div class="control-relay h3 m-0" data-url="{{route($integration .'.set', ['properti_id' => $property->id,'value' => ((int) !$lastValue)])}}">
    @if ($lastValue == 1)
    <i class="fas fa-toggle-on"></i>
    @else
    <i class="fas fa-toggle-off"></i>
    @endif
</div>
@else
<div class="control-relay h3 m-0 text-primari" data-url="{{route($integration .'.set', ['properti_id' => $property->id,'value' => ((int) 1)])}}">
    <i class="fas fa-toggle-off"></i>
</div>
@endif