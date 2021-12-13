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
    @if (method_exists($property, 'getGraphSupport') && $property->getGraphSupport() && !$property->device->offline)
        <canvas class="chart-js-property-prewiew-graph" id="chart-js-container-{{ $property->id }}"
            data-data-url="{{ route('controls.ajax.chart.prewiev', ['property_id' => $property->id]) }}"
            data-data-max="{{ $property->max_value }}" data-data-min="{{ $property->min_value }}" height="40vh"
            width="80vw" class="rounded">
        </canvas>
    @endif
</div>
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

    $('.chart-js-property-prewiew-graph').each(function(index) {
        var chart = new Chart($(this), options);
        ajax_chart(chart, $(this).data("dataUrl"), );
    });
</script>
