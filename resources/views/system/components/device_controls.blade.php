<div class="btn btn-info p-1">
    @php
        $icon = 'fa-upload';
        $color = '';
        //Todo: move to controller of component Laravell Componnents
        //Firmware Status
        if (!empty($device->data->network->mac)) {
            $localBinary = storage_path('app/firmware/' . $device->id . '-' . md5($device->data->network->mac) . '.bin');
        
            if (!empty($device->data->firmware->hash) && file_exists($localBinary)) {
                $hash = md5_file($localBinary);
                if ($hash == $device->data->firmware->hash) {
                    $icon = 'fa-check-circle';
                    $color = 'green';
                } else {
                    $icon = 'fa-arrow-circle-up';
                    $color = '#6495ED';
                }
            }
        }
    @endphp

    @if ($device->integration == '0' || $device->integration == 'others')
        <div class="btn btn-primary">
            <form method="POST" id="firmware-form-{{ $device->id }}" action="{{ route('system.devices.firmware') }}"
                accept-charset="UTF-8" class="d-flex justify-content-between ml-auto" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <input required="required" name="id" type="hidden" value="{{ $device->id }}">
                <label for="firmware-{{ $device->id }}" aria-hidden="true">
                    <i class="fas <?php echo $icon; ?>" style="color: <?php echo $color; ?>;"></i>
                </label>
                <input class="" id="firmware-{{ $device->id }}" style="display:none"
                    onchange="$('form#firmware-form-{{ $device->id }}').submit();" required="required" name="firmware"
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

    @if ($device->settings_count > 0)
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
