@extends('layouts.app')
@section('title', 'Diagnostics')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
{!! form($logForm) !!}
<pre style="overflow: auto;">
    {{ $content }}
</pre>
@endsection