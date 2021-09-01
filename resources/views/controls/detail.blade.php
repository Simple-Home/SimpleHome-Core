@extends('layouts.detail')
@section('title', trans('simplehome.properties.detail.pageTitle') )

@section('customeHead')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endsection

@section('content')
<div class="container p-0">
    <div class="row justify-content-between">
        <div class="col p-md-0">
            <a style="font-weight:bold" class="h4 fw-bold" href="{{route('controls.room', $property->room->id)}}">{{"< ". $property->room->name}}</a>
        </div>
        <div class="col p-md-0 text-right my-auto">
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
                        <td>{{$value['created_at']->diffForHumans()}}</td>
                        <td>{{$value['value']}}</td>
                        <td>{{$value['done']}}</td>
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