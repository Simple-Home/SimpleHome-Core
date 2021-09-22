@extends('layouts.app')
@section('title', 'maintenance')

@section('subnavigation')
@include('system.components.subnavigation')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-2 p-0">
                    {{__('simplehome.records')}}: {{ $totalRecords }}
                </div>

                <div class="col-3 ml-auto p-0">
                    <a href="{{route('system.housekeepings.run')}}">
                        <button type="button" class="w-100 btn btn-primary">{{__('simplehome.housekeeping.runJob')}}</button>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <form action="{{route('system.housekeepings.save')}}" method="post">
                        <div class="form-group row">
                            <div class="form-check">
                                <input class="form-check-input" name="housekeeping_active" type="checkbox" value="1" id="active" @if ($settings['active']->value != 0) checked="checked" @endif>
                                <label class="form-check-label" for="active">
                                    {{__('simplehome.active')}}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="interval">{{__('simplehome.housekeeping.interval')}}</label>
                            <input type="number" name="housekeeping_interval" class="form-control" id="interval" value="{{$settings['interval']->value}}" placeholder="Password">
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary">{{__('simplehome.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection