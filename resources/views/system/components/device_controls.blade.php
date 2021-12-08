<div class="btn btn-info p-1">
    @if ($device->integration == '0' || $device->integration == 'others')
        <div class="btn btn-primary">
            <form method="POST" id="firmware-form-{{ $device->id }}"
                action="{{ route('system.devices.firmware', ['FormBuilder' => $device->firmware]) }}"
                accept-charset="UTF-8" class="d-flex justify-content-between ml-auto" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <input required="required" name="id" type="hidden" value="{{ $device->id }}">
                <label for="firmware" aria-hidden="true">
                    <i class="fas fa-upload"></i>
                </label>
                <input class="" id="firmware" style="display:none"
                    onchange="$('#firmware-form-{{ $device->id }}').submit();" required="required" name="firmware"
                    type="file">
            </form>
        </div>
    @endif

    <a href="{{ route('system.devices.edit', $device->id) }}" class="btn btn-primary"
        title="{{ __('simplehome.edit') }}"><i class="fa fa-pen"></i></a>

    @if (Route::has($device->integration . '.devices.reboot'))
        <a href="{{ route($device->integration . '.devices.reboot', $device->id) }}" class="btn btn-primary"
            title="{{ __('simplehome.reboot') }}"><i class="fas fa-redo"></i></a>
    @endif

    @if ($device->settingsCount > 0)
        <a href="{{ route('system.devices.settings', $device->id) }}" class="btn btn-primary"
            title="{{ __('simplehome.settings') }}"><i class="fas fa-cog"></i></a>
    @endif
    @if ($device->approved)
        <a href="{{ route('system.devices.disapprove', $device->id) }}" class="btn btn-primary"
            title="{{ __('simplehome.disable') }}"><i class="fas fa-times"></i></a>
    @else
        <a href="{{ route('system.devices.approve', $device->id) }}" class="btn btn-primary"
            title="{{ __('simplehome.enable') }}"><i class="fas fa-check"></i></a>
    @endif
    <a href="{{ route('system.devices.remove', $device->id) }}" class="btn btn-danger"
        title="{{ __('simplehome.delete') }}"><i class="fas fa-trash"></i></a>
</div>
