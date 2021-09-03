@extends('layouts.detail')


@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <a style="font-weight:bold" class="h4 fw-bold" href="{{route('controls.detail', $property->id)}}">Detail</a>
            {!! form($propertyForm) !!}
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/bootstrap-Iconspicker-laravel_notSubmit.js') }}" defer></script>
@endsection