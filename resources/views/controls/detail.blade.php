@extends('layouts.detail')
@section('title', trans('simplehome.properties.detail.pageTitle') )

@section('customeHead')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endsection

@section('content')
<div class="container p-0 pt-2">
    <div class="row justify-content-between">
        <div class="col-md order-md-1 order-1 p-md-0 my-auto col-6">
            <a style="font-weight:bold" class="h4 fw-bold" href="{{route('controls.room', $property->room->id)}}">{{"< ". $property->room->name}}</a>
        </div>
        <div class="col-md-auto text-right order-md-2 order-3 p-md-0 my-auto mr-2 ">
            <!--Period Control-->
            <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'detail') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" id="period_today" href="{{route('controls.detail', $property->id)}}">{{__("simplehome.period.today")}}</a>
            <div class="btn-group" role="group" aria-label="Standard Button Group">
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'day') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" id="period_today" href="{{route('controls.detail', [$property->id, 'day'])}}">{{__("simplehome.period.day")}}</a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'week') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'week'])}}">{{__("simplehome.period.week")}}</a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'month') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'month'])}}">{{__("simplehome.period.month")}}</i></a>
                <a style="font-weight:bold" class="h3 btn {{ ((request()->segment(count(request()->segments())) == 'year') ? 'btn-primary' : 'btn-outline-primary') }} my-auto" href="{{route('controls.detail', [$property->id, 'year'])}}">{{__("simplehome.period.year")}}</i></a>
            </div>
        </div>
        <div class="col-md-auto text-right order-md-3 order-2 p-md-0 my-auto col-6">
            <a style="font-weight:bold" class="h3 fw-bold" href="{{route('controls.edit', $property->id)}}"><i class="fas fa-cog"></i></a>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <div>
                <h3 class="mb-0">{{$property->nick_name}}</h3>
                <p class="mb-0">{{$property->last_value->created_at->diffForHumans()}}</p>
            </div>
        </div>
        <div class="col p-md-0 text-right my-auto">
            @if (!empty($property->last_value))
            <h4 class="text-right">
                {{$property->last_value->value}}
            </h4>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($propertyDetailChart)
            <div style="heigth:30%;">
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
                        <th scope="col">Value</th>
                        <th scope="col">Done</th>
                    </tr>
                </thead>
                @foreach ($table as $value)
                <tbody>
                    <tr>
                        <td>{{$value->created_at->diffForHumans()}}</td>
                        <td>{{$value->value}}</td>
                        <td>{{$value->done}}</td>
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