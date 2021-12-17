<div class="card m-0 rounded-5 {{ $property->device->offline ? 'is-offline' : 'is-online' }} position-relative"
    style="height: 100px; cursor: pointer;">
    <div class="container pt-2 py-2 device-container" style="z-index:1;">
        <div class="d-flex justify-content-between">
            <a class="h2 my-auto device-icon" href="{{ route('controls.detail', $property->id) }}">
                <i class="fas {{ $property->icon }}"></i>
            </a>
            <div class="text-right text-nowrap">
                <div class="d-flex justify-content-start device-value">
                    @if (View::exists('controls.components.types.' . $property->type))
                        @include('controls.components.types.' . $property->type, $property)
                    @else
                        @if (isset($property->latestRecord))
                            @if (is_numeric($property->latestRecord->value))
                                {{ round($property->latestRecord->value, 2) }}
                            @else
                                {{ $property->latestRecord->value }}
                            @endif
                            <small style="color: #686e73;">
                                {{ $property->units }}
                            </small>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <p class="m-0">{{ ucwords($property->nick_name) }}</p>
    </div>
    @if (method_exists($property, 'getGraphSupport') && $property->getGraphSupport())
        <div style="width:100%;height:100%;" class="position-absolute">
            <canvas id="chartJSContainer-{{ $property->id }}" height="40vh" width="80vw" class="rounded">
                <script>
                    var style = getComputedStyle(document.body);
                    var primCol = style.getPropertyValue('--bs-primary');

                    var timeFormat = 'Y-m-d H:i:s';
                    var options = {
                        type: 'line',
                        data: {},
                        options: {
                            borderColor: primCol,
                            elements: {
                                point: {
                                    radius: 0
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    top: 0.79,
                                    left: -10,
                                    bottom: -10
                                },
                                autoPadding: false,
                            },
                            animation: {
                                duration: 555
                            },
                            tooltips: {
                                enabled: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    enabled: false
                                },
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        beginAtZero: true,
                                        display: false,
                                        {{ is_int($property->min_value) && isset($property->min_value) ? 'min: ' . ($property->min_value - 5) . ',' : '' }}
                                        {{ is_int($property->max_value) && isset($property->max_value) ? 'max: ' . ($property->max_value + 5) . ',' : '' }}
                                    },
                                    grid: {
                                        drawBorder: false,
                                        display: false
                                    },
                                },
                                y: {
                                    ticks: {
                                        beginAtZero: true,
                                        display: false,
                                    },
                                    grid: {
                                        drawBorder: false,
                                        display: false,
                                    }
                                }
                            },
                        },
                    };

                    var ctx = $('#chartJSContainer-{{ $property->id }}');
                    var chart = new Chart(ctx, options);
                </script>

                @if (!$property->device->offline)
                    <script>
                        ajax_chart(chart);

                        function ajax_chart(chart) {
                            var data = data || {};
                            $.ajax({
                                dataType: "json",
                                start_time: new Date().getTime(),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                type: 'GET',
                                url: '{{ route('controls.ajax.chart.prewiev', ['property_id' => $property->id]) }}',
                                success: function(json) {
                                    chart.data = json;
                                    chart.update();
                                    console.log((new Date().getTime() - this.start_time) + ' ms');
                                },
                                error: function() {
                                    console.log((new Date().getTime() - this.start_time) + ' ms');
                                },
                                timeout: 3000,
                            });
                        }
                    </script>
                @endif
            </canvas>
        </div>
    @endif
</div>
