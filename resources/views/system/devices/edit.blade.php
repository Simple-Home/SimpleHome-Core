@extends('layouts.detail')

@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <a style="font-weight:bold" class="h4 text-decoration-none fw-bold" href="{{route('system.devices.detail', $device->id)}}"><i class="fas fa-chevron-left me-2"></i>Detail</a>
            {!!  form_start($deviceForm) !!}
            {!!  form_until($deviceForm, 'integration') !!}
            @if (!empty ($integrations))
                <datalist id="integrations">
                    @foreach ($integrations as $value)
                        <option value="{{ $value }}"></option>
                    @endforeach
                </datalist>
            @endif
            {!!  form_end($deviceForm) !!}
            <div class="mt-3">
                <a href="{{route('system.devices.remove', $device->id)}}" class="btn btn-danger btn-block">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection