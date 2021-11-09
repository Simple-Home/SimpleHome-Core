          <div class="card p-2 m-0 rounded-5 {{ $property->device->offline ? 'is-offline' : 'is-online' }} }}"
              style="height: 100px; cursor: pointer;">
              <div class="container p-0 device-container">
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
                  <p class="">{{ ucwords($property->nick_name) }}</p>
                  <canvas style="display: block; box-sizing: border-box;" id="chartJSContainer-{{ $property->id }}">
                      <script>
                          window.addEventListener("load", function() {
                              var options = {
                                  type: 'line',
                                  data: {
                                      labels: [""],
                                      datasets: [{
                                          data: [12, 19, 3, 5, 2, 3],
                                      }]
                                  },
                                  plugin: {
                                      legend: false,
                                  }
                              }

                              var ctx = $('#chartJSContainer-{{ $property->id }}');
                              new Chart(ctx, options);
                          });
                      </script>
                  </canvas>
              </div>
          </div>
