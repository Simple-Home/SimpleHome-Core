@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
    @if (!empty($properti))
        <div class="row row-cols-1 row-cols-md-3">
            <div class="col-sm col-md-1">
            <div class="text-center">
                <h1 class="text-cente">
                    <i class="fas {{$properti->icon}}"></i>
                </h1>
            </div>

            </div>
            <div class="col-sm col-md-5">
                <h5 class="card-title">{{$properti->type}}</h5>
                <h4>{{$properti->device->hostname}}</h5>
            </div>
            <div class="col-sm col-md-6">
                @if (!empty ($properti->lastValue))
                <h4 class="text-right">{{$properti->lastValue->value}}</h4>
                @endif
            </div>
        </div>
        @if ($propertyDetailChart)
            <div style="heigth:30%;">
                {!! $propertyDetailChart->render() !!}
            </div>
        @endif
        @if(!empty($properti->values) && count($properti->values) > 0)
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Created</th>
                            <th scope="col">Value</th>
                            <th scope="col">Done</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properti->values as $value)
                        <tr>
                            <td>{{$value->created_at->diffForHumans() }}</td>
                            <td>{{$value->value}}</td>
                            <td>{{$value->done}}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-center">{{ __('Nothing Found') }}</p>
            @endif
        @endif
    </div>
</div>
@endsection