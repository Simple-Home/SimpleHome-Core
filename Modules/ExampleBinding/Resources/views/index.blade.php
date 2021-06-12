@extends('exampleLight::layouts.master')

@section('content')
    <h1>Example Module</h1>

    <p>
        This view is loaded from module: {!! config('exampleLight.name') !!}
    </p>
@stop
