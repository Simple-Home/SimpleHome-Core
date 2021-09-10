<a href="{{route('endpoints.devices.edit', $device->id)}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

@if ($device->type == "0" || $device->type == "Other")
<a href="/test" class="btn btn-primary"><i class="fas fa-upload"></i></a>
<a href="/test" class="btn btn-primary"><i class="fas fa-terminal"></i></a>
@endif
<a href="{{ route($device->integration .'.devices.reboot', $device->id) }}" class="btn btn-primary"><i class="fas fa-redo"></i></a>

@if ($device->settingsCount > 0)
<a href="{{ route('devices_settings', $device->id) }}" class="btn btn-primary"><i class="fas fa-cog"></i></a>
@endif

@if ($device->approved)
<a href="{{ route('endpoints.devices.disapprove', $device->id) }}" class="btn btn-primary"><i class="fas fa-times"></i></a>
@else
<a href="{{ route('endpoints.devices.approve', $device->id) }}" class="btn btn-primary"><i class="fas fa-check"></i></a>
@endif

<a href="{{route('endpoints.devices.remove', $device->id)}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>