@extends('layouts.detail')
@section('title', trans('simplehome.properties.detail.pageTitle') )

@section('customeHead')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<style>
    .square {
        padding-top: 100% !important;
    }
</style>
@endsection

@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col-md order-md-1 order-1 p-md-0 my-auto col-6">
            <a style="font-weight:bold" class="h4 text-capitalize text-decoration-none fw-bold" href="{{route('controls.room', $property->room->id)}}"><i class="fas fa-chevron-left me-2"></i>{{$property->room->name}}</a>
        </div>
        <div class="col-md-auto text-right order-md-2 order-3 p-md-0 my-auto me-md-2 d-flex d-md-block justify-content-between">
            <!--Period Selector-->
            {{--
                <div class="d-md-inline d-none h3 my-auto">
                    <a href="#"><i class="fas fa-chevron-left"></i></a>
                    Datum
                    <a href="#"><i class="fas fa-chevron-right"></i></a>
                </div>
            --}}
            <!--Period Control-->
            <a class="h3 fw/bod btn {{ ((request()->segment(count(request()->segments())) == 'detail') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" id="period_today" href="{{route('controls.detail', $property->id)}}">{{__("simplehome.period.today")}}</a>
            <div class="btn-group" role="group" aria-label="Standard Button Group">
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'day') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" id="period_today" href="{{route('controls.detail', [$property->id, 'day'])}}">{{__("simplehome.period.day")}}</a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'week') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'week'])}}">{{__("simplehome.period.week")}}</a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'month') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'month'])}}">{{__("simplehome.period.month")}}</i></a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'year') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'year'])}}">{{__("simplehome.period.year")}}</i></a>
            </div>
        </div>
        <div class="col-md-auto text-end order-md-3 order-2 p-md-0 my-auto col-6">
            <a style="font-weight:bold" class="h3 fw-bold" href="{{route('controls.edit', $property->id)}}"><i class="fas fa-cog"></i></a>
        </div>
    </div>
    <div class="row justify-content-between">
        <div style="width: 50px; height: 50px;" class="col p-md-0 col-auto d-flex ">
            <span class="mx-auto my-auto h1">
                <i class="fas {{$property->icon}}"></i>
            </span>
        </div>
        <div class="col p-md-0">
            <div>
                <h3 class="mb-0">{{$property->nick_name}}</h3>
                @if(isset($property->latestRecord->created_at))
                <p class="mb-0">{{$property->latestRecord->created_at->diffForHumans()}}</p>
                @endif
            </div>
        </div>
        <div class="col p-md-0 text-end my-auto">
            @if (!empty($property->latestRecord))
            <h1 class="text-end font-weight-bold">
                {{$property->latestRecord->value}} {{$property->units}}
            </h1>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($propertyDetailChart)
            <div class="h-30">
                {!! $propertyDetailChart->render() !!}
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if(!empty($table) && count($table) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Created</th>
                        <th scope="col">(Min/Avg/Max)</th>
                        <th scope="col">Done</th>
                    </tr>
                </thead>
                @foreach ($table as $value)
                <tbody>
                    <tr>
                        <td>{{$value->created_at->diffForHumans()}}</td>
                        <td>({{$value->min}} {{$property->units}}/{{$value->value}} {{$property->units}}/{{$value->max}} {{$property->units}})</td>
                        <td>
                            @if ($value->done)
                            <i class="fas fa-check"></i>
                            @else
                            <i class="fas fa-times"></i>
                            @endif
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            @else
            <p class="text-center">{{ __('Nothing Found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection