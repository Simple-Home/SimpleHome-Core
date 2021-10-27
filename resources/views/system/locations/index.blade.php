@extends('layouts.app')
@section('title', trans('simplehome.locations.pageTitle'))

@section('subnavigation')
    @include('system.components.subnavigation')
@endsection

@section('content')

    @include('components.search')
    <div id="ajax-loader" class="h-100" data-url="{{ route('system.locations.ajax.list') }}">
        <div class="d-flex h-100">
            <div class="text-center m-auto">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="locationCreation" tabindex="-1" aria-labelledby="locationCreation" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="private-token" class="" method="POST"
                    action="{{ route('system.locations.create') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="col-auto">
                            <label for="postitionName" class="visually-hidden"></label>
                            <input type="text" class="form-control" name="postitionName" id="postitionName"
                                placeholder="Location Name" required>
                        </div>
                    </div>
                    <div id="map" class="map my-2" tabindex="0"></div>
                    <link rel="stylesheet"
                        href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/css/ol.css"
                        type="text/css">
                    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/build/ol.js"></script>

                    <style>
                        .map {
                            height: 400px;
                            width: 100%;
                        }

                    </style>

                    <div class="modal-body">
                        <div class="col-auto">
                            <label for="positionRadius" class="visually-hidden"></label>
                            <input type="number" class="form-control" name="positionRadius" id="positionRadius"
                                placeholder="Radius (m)" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="col-auto">
                            <label for="postitionLat" class="visually-hidden"></label>
                            <input type="text" class="form-control" name="postitionLat" id="postitionLat"
                                placeholder="Lat" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="col-auto">
                            <label for="postitionLong" class="visually-hidden"></label>
                            <input type="text" class="form-control" name="postitionLong" id="postitionLong"
                                placeholder="long" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('beforeBodyEnd')
    <script src="{{ asset(mix('js/locations.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script>
        $('#locationCreation').on('shown.bs.modal', function(e) {
            console.log("Loading - OpenLayers");
            const iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([14.4694954, 50.0779599])),
                name: 'Somewhere near Nottingham',
            });

            if (map != undefined || map != null) {
                const map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM(),
                        })
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat([14.4694954, 50.0779599]),
                        zoom: 18
                    })
                });
            }

            function display(id, value) {
                document.getElementById(id).value = value;
            }

            var marker;


            map.on('click', function(evt) {
                var coordinate = ol.proj.toLonLat(evt.coordinate);
                console.log(coordinate);
                display("postitionLat", coordinate[0]);
                display("postitionLong", coordinate[1])
                locationVisualizer(coordinate, document.getElementById("positionRadius").value)
            });

            function locationVisualizer(coordinate, radius) {
                if (marker) {
                    map.removeLayer(marker);
                }

                console.log(parseInt(radius));

                var markerFeautre = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat(
                        coordinate)),
                    name: 'Marker',
                })

                var circle = new ol.geom.Circle(ol.proj.transform(coordinate, 'EPSG:4326',
                    'EPSG:3857'), parseInt(radius));

                var radiusFeautre = new ol.Feature({
                    geometry: circle,
                    name: 'Radius',
                })

                marker = new ol.layer.Vector({
                    source: new ol.source.Vector({
                        features: [markerFeautre, radiusFeautre]
                    }),
                    style: new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 46],
                            anchorXUnits: 'fraction',
                            anchorYUnits: 'pixels',
                            src: 'https://openlayers.org/en/latest/examples/data/icon.png',
                            fill: new ol.style.Fill({
                                color: 'rgba(55, 200, 150, 0.5)'
                            }),
                            stroke: new ol.style.Stroke({
                                width: 10,
                                color: 'rgba(55, 200, 150, 0.8)'
                            }),
                            radius: 1
                        }),
                        fill: new ol.style.Fill({
                            color: 'rgba(20, 100, 240, 0.3)'
                        }),
                        stroke: new ol.style.Stroke({
                            width: 3,
                            color: 'rgba(0, 100, 240, 0.8)'
                        }),
                    })
                });
                map.addLayer(marker);
            }


            $(':input#positionRadius').on('input', function(e) {
                locationVisualizer([
                        document.getElementById("postitionLat").value,
                        document.getElementById("postitionLong").value
                    ],
                    document.getElementById("positionRadius").value)
            });
        });
    </script>
@endsection
