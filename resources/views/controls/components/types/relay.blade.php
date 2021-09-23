<?php
$integration = $property->device->integration;
?>
@if (isset($property->latestRecord->value))
<?php $lastValue = $property->latestRecord->value; ?>
<button class="relay h2" data-url="{{route($integration .'.set', ['properti_id' => $property->id,'value' => ((int) !$lastValue)])}}">
    @if ($lastValue == 1)
    <i class="fas fa-toggle-on"></i>
    @else
    <i class="fas fa-toggle-off"></i>
    @endif
</button>
@else
<button class="relay h2" data-url="{{route($integration .'.set', ['properti_id' => $property->id,'value' => ((int) 1)])}}">
    <i class="fas fa-toggle-off"></i>
</button>
@endif