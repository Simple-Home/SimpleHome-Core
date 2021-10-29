@extends('layouts.app')
@section('title', trans('simplehome.locations.pageTitle'))

@section('customHead')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/css/ol.css"
        type="text/css">
    <style>
        .map {
            height: 400px;
            width: 100%;
        }

    </style>
    <link rel="stylesheet"
        href="{{ asset('css/bootstrap-iconpicker.min.css', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" />
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
        defer></script>
    <script type="text/javascript"
        src="{{ asset('js/bootstrap-iconpicker.bundle.min.js', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        defer></script>
@endsection


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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.locations.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('beforeBodyEnd')

    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.8.1/build/ol.js"></script>
    <script src="{{ asset(mix('js/locations.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script>
        let map;
        var marker;

        $('body').on('click', 'button.location-edit', function(e) {
            map = null;
            url = $(this).data("url");
            console.log(url);

            form = $('#locationCreation');
            formContent = form.find('.modal-body');
            formContent.html("<div class=\"spinner-border text-primary\" role=\"status\"></div>");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                success: function(msg) {
                    formContent.replaceWith(msg);
                    form.modal('show');
                }
            });
        });

        $('body').on('click', 'button#positionIconOpener', function(e) {
            $('div#positionIconOpener').iconpicker({
                align: 'center', // Only in div tag
                arrowClass: 'btn-danger',
                unselectedClass: '',
                search: true,
                footer: true,
                header: true,
                rows: 4,
                cols: 11,
                selectedClass: 'btn-primary',
                arrowPrevIconClass: 'fas fa-angle-left',
                arrowNextIconClass: 'fas fa-angle-right',
            });
            e.preventDefault();
        });

        $('#locationCreation').on('shown.bs.modal', function(e) {
            console.log("Loading - OpenLayers");
            if ($('#map').html() == undefined || $('#map').html() == null || $('#map').html() == '') {
                console.log("Initializing - OpenLayers");

                var position = [14.4694954, 50.0779599];
                var radius = null;

                if (
                    document.getElementById("postitionLat").value != "" &&
                    document.getElementById("postitionLong").value != ""
                ) {
                    position = [
                        document.getElementById("postitionLat").value,
                        document.getElementById("postitionLong").value
                    ];
                    radius = document.getElementById("postitionLong").value;
                } else if (navigator.geolocation) {
                    console.log("Geting Location from Browser");
                    navigator.geolocation.getCurrentPosition(function(position) {
                        position = [position.coords.latitude, position.coords.longitude];
                    });
                }

                const iconFeature = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat(position)),
                    name: 'Your Location',
                });

                map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM(),
                        }),
                        new ol.layer.Vector({
                            source: new ol.source.Vector({
                                features: [iconFeature]
                            })
                        })
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat(position),
                        zoom: 18
                    })
                });

                if (radius != null) {
                    locationVisualizer(position, radius);
                }
            }

            map.on('click', function(evt) {
                var coordinate = ol.proj.toLonLat(evt.coordinate);
                console.log(coordinate);
                display("postitionLat", coordinate[0]);
                display("postitionLong", coordinate[1])
                locationVisualizer(coordinate, document.getElementById("positionRadius").value)
            });

            $(':input#positionRadius').on('input', function(e) {
                locationVisualizer([
                        document.getElementById("postitionLat").value,
                        document.getElementById("postitionLong").value
                    ],
                    document.getElementById("positionRadius").value)
            });
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

        function display(id, value) {
            document.getElementById(id).value = value;
        }
    </script>
    <script>
        $('#locationCreation').on('shown.bs.modal', function(e) {
            /*console.log("Loading - OpenLayers");

                if (map == undefined || map == null) {
                    var position = [14.4694954, 50.0779599];

                    if (navigator.geolocation) {
                        console.log("Geting Location from Browser");
                        navigator.geolocation.getCurrentPosition(function(position) {
                            position = [position.coords.latitude, position.coords.longitude];
                        });
                    }
                    const iconFeature = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat(position)),
                        name: 'Your Location',
                    });

                    map = new ol.Map({
                        target: 'map',
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.OSM(),
                            }),
                            new ol.layer.Vector({
                                source: new ol.source.Vector({
                                    features: [iconFeature]
                                })
                            })
                        ],
                        view: new ol.View({
                            center: ol.proj.fromLonLat(position),
                            zoom: 18
                        })
                    });
                }

              

                var marker;

                

                


            $(':input#positionRadius').on('input', function(e) {
                locationVisualizer([
                        document.getElementById("postitionLat").value,
                        document.getElementById("postitionLong").value
                    ],
                    document.getElementById("positionRadius").value)
            });
            */
        });
    </script>
@endsection
