@extends('layouts.detail')
@section('title', trans('simplehome.properties.detail.pageTitle'))

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
                <a style="font-weight:bold" class="h4 text-capitalize text-decoration-none fw-bold"
                    href="{{ route('controls.list') }}"><i
                        class="fas fa-chevron-left me-2"></i>{{ $property->room->name }}</a>
            </div>
            <div
                class="col-md-auto text-right order-md-2 order-3 p-md-0 my-auto me-md-2 d-flex d-md-block justify-content-between">
                <!--Period Selector-->
                {{-- <div class="d-md-inline d-none h3 my-auto">
                    <a href="#"><i class="fas fa-chevron-left"></i></a>
                    Datum
                    <a href="#"><i class="fas fa-chevron-right"></i></a>
                </div> --}}
                <!--Period Control-->
                <a class="h3 fw/bod btn {{ request()->segment(count(request()->segments())) == 'detail' ? 'btn-primary' : 'btn-outline-primary' }} my-auto"
                    id="period_today"
                    href="{{ route('controls.detail', $property->id) }}">{{ __('simplehome.period.today') }}</a>
                <div class="btn-group" role="group" aria-label="Standard Button Group">
                    <a style="font-weight:bold"
                        class="h3 btn {{ request()->segment(count(request()->segments())) == 'day' ? 'btn-primary' : 'btn-outline-primary' }} my-auto"
                        id="period_today"
                        href="{{ route('controls.detail', [$property->id, 'day']) }}">{{ __('simplehome.period.day') }}</a>
                    <a style="font-weight:bold"
                        class="h3 btn {{ request()->segment(count(request()->segments())) == 'week' ? 'btn-primary' : 'btn-outline-primary' }} my-auto"
                        href="{{ route('controls.detail', [$property->id, 'week']) }}">{{ __('simplehome.period.week') }}</a>
                    <a style="font-weight:bold"
                        class="h3 btn {{ request()->segment(count(request()->segments())) == 'month' ? 'btn-primary' : 'btn-outline-primary' }} my-auto"
                        href="{{ route('controls.detail', [$property->id, 'month']) }}">{{ __('simplehome.period.month') }}</i></a>
                    <a style="font-weight:bold"
                        class="h3 btn {{ request()->segment(count(request()->segments())) == 'year' ? 'btn-primary' : 'btn-outline-primary' }} my-auto"
                        href="{{ route('controls.detail', [$property->id, 'year']) }}">{{ __('simplehome.period.year') }}</i></a>
                </div>
            </div>
            <div class="col-md-auto text-end order-md-3 order-2 p-md-0 my-auto col-6">
                <a style="font-weight:bold" class="h3 fw-bold" href="{{ route('controls.edit', $property->id) }}"><i
                        class="fas fa-cog"></i></a>
            </div>
        </div>
        <div class="row justify-content-between">
            @if (!empty($property->icon) && $property->icon != 'empty')
                <div style="width: 50px; height: 50px;" class="col p-md-0 col-auto d-flex ">
                    <span class="mx-auto my-auto h1">
                        <i class="fas {{ $property->icon }}"></i>
                    </span>
                </div>
            @endif
            <div class="col p-md-0">
                <div>
                    <h3 class="mb-0">{{ $property->nick_name }}</h3>
                    @if (isset($property->latestRecord->created_at))
                        <p class="mb-0"
                            data-time=" {{ __('simplehome.last.change') }} {{ $property->latestRecord->created_at->format(config('ui.time_format')) }}">
                            {{ __('simplehome.last.change') }}
                            {{ $property->latestRecord->created_at->diffForHumans() }}
                        </p>

                    @endif
                </div>
            </div>
            <div class="col p-md-0 text-end my-auto">
                @if (!empty($property->latestRecord))
                    <div class="d-flex justify-content-end">
                        @if (View::exists('controls.components.types.' . $property->type))
                            <div class="h1 my-auto">
                                @include('controls.components.types.' . $property->type, $property)
                            </div>
                        @else
                            @if (isset($property->latestRecord))
                                <div class="text-end h1 font-weight-bold">
                                    {{ $property->latestRecord->value }}
                                </div>
                                <div class="h4" style="color: #686e73;">
                                    {{ $property->units }}
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if ($property->getGraphSupport())
                    @if ($propertyDetailChart)
                        <div class="h-30">
                            {!! $propertyDetailChart->render() !!}
                        </div>
                    @endif
                @elseif ($property->type == 'location')
                    <p>Loation</p>

                    @php
                        $lat = explode(',', $property->latestRecord->value)[0];
                        $long = explode(',', $property->latestRecord->value)[1];
                    @endphp

                    <link rel="stylesheet"
                        href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/css/ol.css"
                        type="text/css">
                    <style>
                        .map {
                            height: 400px;
                            width: 100%;
                        }

                    </style>
                    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/build/ol.js"></script>
                    <div id="map" class="map"></div>
                    <script type="text/javascript">
                        const iconFeature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.fromLonLat([{{ $long }}, {{ $lat }}])),
                            name: 'Somewhere near Nottingham',
                        });

                        const map = new ol.Map({
                            target: 'map',
                            layers: [
                                new ol.layer.Tile({
                                    source: new ol.source.OSM(),
                                }),
                                new ol.layer.Vector({
                                    source: new ol.source.Vector({
                                        features: [iconFeature]
                                    }),
                                    style: new ol.style.Style({
                                        image: new ol.style.Icon({
                                            anchor: [0.5, 46],
                                            anchorXUnits: 'fraction',
                                            anchorYUnits: 'pixels',
                                            src: 'https://openlayers.org/en/latest/examples/data/icon.png'
                                        })
                                    })
                                })
                            ],
                            view: new ol.View({
                                center: ol.proj.fromLonLat([{{ $long }}, {{ $lat }}]),
                                zoom: 18
                            })
                        });
                    </script>


                @elseif ($property->type == 'relay' || $property->type == 'event')
                    <p>Relay</p>

                    {{-- Timeline --}}
                    @if (!empty($table) && count($table) > 0)
                        <div class="row">
                            <div class="col d-flex justify-content-md-around justify-content-after">
                                <div>
                                    @foreach ($table as $value)
                                        <!-- Timeline item start -->
                                        <div class="row">
                                            <div class="col-auto text-center">
                                                <div class="row h-33">
                                                    <div
                                                        class="col {{ !$loop->first ? 'border-end border-secondary' : '' }}">
                                                        &nbsp;</div>
                                                    <div class="col">&nbsp;</div>
                                                </div>
                                                <h5 class="row h-33 m-1">
                                                    <span class="badge rounded-circle bg-primary border">&nbsp;
                                                    </span>
                                                </h5>
                                                <div class="row h-33">
                                                    <div
                                                        class="col {{ !$loop->last ? 'border-end border-secondary' : '' }}">
                                                        &nbsp;</div>
                                                    <div class="col">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div class="col my-auto">
                                                <div class="d-inline">
                                                    <h4 class="text-muted">
                                                        {{-- TODO: ADD Translation to Visual state if possible :) --}}
                                                        {{--  --}}

                                                        @if ($property->type == 'relay')
                                                            @if ($value->value == 1)
                                                                <i class="fas fa-toggle-on text-primary"></i>
                                                            @else
                                                                <i class="fas fa-toggle-off"></i>
                                                            @endif
                                                        @else
                                                            {{ $value->value }}{{ $property->units }}
                                                        @endif
                                                    </h4>
                                                    <p class="mb-0">{{ $value->origin }}</p>
                                                    <p class="mb-0"
                                                        data-time="{{ $value->created_at->format(config('ui.datetime_format_short')) }}">
                                                        {{ $value->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Timeline item end -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>

        <div class="row">
            <div class="col">
                @if ($property->getGraphSupport())
                    {{-- Table --}}
                    @if (!empty($table) && count($table) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Created</th>
                                    <th scope="col">Origin</th>
                                    @if ($property->type != 'event' || $property->graphSupport == true)
                                        <th scope="col">(Min/Avg/Max)</th>
                                    @else
                                        <th scope="col">Value</th>
                                    @endif
                                    <th scope="col">Done</th>
                                </tr>
                            </thead>
                            @foreach ($table as $value)
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0"
                                                data-time="{{ $value->created_at->format(config('ui.datetime_format_short')) }}">
                                                {{ $value->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td>{{ $value->origin }}</td>
                                        {{-- TODO: ADD Translation to Visual state if possible :) --}}
                                        {{--  --}}
                                        @if ($property->type != 'event' || $property->graphSupport == true)
                                            <td>({{ $value->min }} {{ $property->units }}/{{ $value->value }}
                                                {{ $property->units }}/{{ $value->max }}
                                                {{ $property->units }})
                                            </td>
                                        @else
                                            <td>{{ $value->value }} {{ $property->units }}</td>
                                        @endif
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
                @endif
            </div>
        </div>
    </div>
    <script>
        $('body').on('click', '[data-time]', function(event) {
            $('[data-time]').each(function(index) {
                var oldValue = $(this).text()
                console.log("[ajaxAction]-url:", $(this).data("time"));
                $(this).text($(this).data("time"))
                $(this).data("time", oldValue)
            });;
        });
    </script>
@endsection
