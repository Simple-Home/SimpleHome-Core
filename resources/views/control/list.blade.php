
@extends('layouts.app')

@section('subnavigation')
@include('control.components.subnavigation', $rooms)
@endsection

@section('content')
    @if(!empty($propertyes) && count($propertyes) > 0)
        <div class="row row-cols-2 row-cols-md-3">
            @foreach ($propertyes as $property)
                <div class="col mb-4">
                    @include('control.components.item', $property)
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">{{ __('No controls Found') }}</p>
    @endif
@endsection