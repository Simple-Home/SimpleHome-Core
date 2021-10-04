@extends('layouts.detail')


@section('content')
<script type="text/javascript" src="{{ asset('js/bootstrap-Iconspicker-laravel.js') }}"></script>



<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <a style="font-weight:bold" class="h4 text-capitalize fw-bold" href="{{route('controls.detail', $property->id)}}"><i class="fas fa-chevron-left me-2"></i>Detail</a>
            <div class="card mt-2">
                <div class="card-header">
                    {{__('simplehome.properti.edit')}}
                </div>
                <div class="card-body">
                    {!! form($propertyForm) !!}
                    <div class="mt-3">
                        <a href="{{route('controls.remove', $property->id)}}" class="btn btn-danger btn-block">Delete</a>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    {{__('simplehome.properti.custome.settings')}}
                </div>
                <div class="card-body">
                    {!! form($systemSettingsForm) !!}
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/bootstrap-Iconspicker-laravel_notSubmit.js') }}" defer></script>
@endsection