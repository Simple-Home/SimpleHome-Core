<a href="{{route('system.devices.edit', $device->id)}}" class="btn btn-primary"><i class="fa fa-pen"></i></a>


@if ($device->integration == "0" || $device->integration == "others")
<a href="/test" class="btn btn-primary"><i class="fas fa-terminal"></i></a>
<form method="POST" action="{{ route('system.devices.firmware' )}}" accept-charset="UTF-8" class="d-flex justify-content-between ml-auto" enctype="multipart/form-data"><input name="_token" type="hidden" value="jOEGhgYzhBdKRkMUNUneHhOVVUj6jTuiMu6jAnjQ">
        <label for="firmware" class="btn btn-primary required" aria-hidden="true">
        <i class="fas fa-upload"></i>
        </label>
        <input class="btn btn-primary" id="firmware" style="display:none" onchange="this.form.submit();" required="required" name="firmware" type="file">
    <input required="required" name="id" type="hidden" value="{{ $device->id }}">
</form>
@endif
<a href="{{ route($device->integration .'.devices.reboot', $device->id) }}" class="btn btn-primary"><i class="fas fa-redo"></i></a>

@if ($device->settingsCount > 0)
<a href="{{ route('system.devices.settings', $device->id) }}" class="btn btn-primary"><i class="fas fa-cog"></i></a>
@endif

@if ($device->approved)
<a href="{{ route('system.devices.disapprove', $device->id) }}" class="btn btn-primary"><i class="fas fa-times"></i></a>
@else
<a href="{{ route('system.devices.approve', $device->id) }}" class="btn btn-primary"><i class="fas fa-check"></i></a>
@endif

<a href="{{route('system.devices.remove', $device->id)}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>