          <div class="card m-0 rounded-5 {{ $property->device->offline ? 'is-offline' : 'is-online' }}"
              style="height: 100px; cursor: pointer;">
              <div class="container pt-2 py-2 device-container">
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
                  <div style="width:100%;height:100%;">
                      <canvas id="chartJSContainer-{{ $property->id }}" height="40vh" width="80vw">
                          <script>
                              var options = {
                                  type: 'line',
                                  data: {
                                      labels: [12, 19, 3, 5, 2, 3],
                                      datasets: [{
                                          data: [12, 19, 3, 5, 2, 3],
                                          borderColor: 'rgb(75, 192, 192)',
                                          tension: 0.5,
                                          fill: false
                                      }],
                                  },
                                  options: {
                                      elements: {
                                          point: {
                                              radius: 0
                                          }
                                      },
                                      responsive: true,
                                      maintainAspectRatio: false,
                                      layout: {
                                          padding: {
                                              left: -10,
                                              bottom: -10
                                          },
                                          autoPadding: false,
                                      },
                                      animation: {
                                          duration: 0
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
                                          y: {
                                              ticks: {
                                                  beginAtZero: true,
                                                  display: false,
                                              },
                                              grid: {
                                                  drawBorder: false,
                                                  display: false,
                                              }
                                          },
                                          x: {
                                              ticks: {
                                                  display: false,
                                              },
                                              grid: {
                                                  drawBorder: false,
                                                  display: false
                                              }
                                          }
                                      },
                                  },
                              };

                              var ctx = $('#chartJSContainer-{{ $property->id }}');
                              var chart = new Chart(ctx, options);
                          </script>
                      </canvas>
                  </div>
              @endif
          </div>
