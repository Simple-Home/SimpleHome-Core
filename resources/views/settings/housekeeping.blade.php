@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('settings.components.subnavigation')
            </div>
            <div class="col">
                @if ($runJob == true)
                    <div class="row">
                        <div class="alert alert-success col-12" role="alert">
                            {{__('simplehome.housekeeping.runJob.triggert')}}
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-2 p-0">
                        {{__('simplehome.records')}} {{ count($records) }}
                    </div>

                    <div class="col-3 ml-auto p-0">
                        <a href="{{route('housekeeping_runjob')}}">
                            <button type="button"
                                    class="w-100 btn btn-primary">{{__('simplehome.housekeeping.runJob')}}</button>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <form action="{{route('housekeeping_saveform')}}" method="post">
                            <div class="form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" name="simplehome_housekeeping_active"
                                           type="checkbox" value="1" id="active"
                                           @if ($settings['simplehome.housekeeping.active'] != 0) checked="checked" @endif>
                                    <label class="form-check-label" for="active">
                                        {{__('simplehome.active')}}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="interval">{{__('simplehome.housekeeping.interval')}}</label>
                                <input type="number" name="simplehome_housekeeping_interval" class="form-control"
                                       id="interval"
                                       value="{{$settings['simplehome.housekeeping.interval']}}" placeholder="Password">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <button type="submit" class="btn btn-primary">{{__('simplehome.save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection