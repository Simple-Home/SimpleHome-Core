<div class="card p-2 m-0 rounded-5" style="height: 100px; cursor: pointer;">
    <div class="container p-0">
        <div class="d-flex justify-content-between">
            <a class="h2" href="{{ route('controls.detail', $property->id) }}">
                <i class="fas {{$property->icon}}"></i>
            </a>
            <div class="text-right text-nowrap">
                <div class="d-flex justify-content-start">
                    @if(View::exists('controls.components.types.' . $property->type))
                    <div class="h3">
                        @include('controls.components.types.' . $property->type, $property)
                    </div>
                    @else
                    @if (isset($property->latestRecord))
                    <div class="h3">
                        @if(is_numeric($property->latestRecord->value))
                        {{ round($property->latestRecord->value, 2) }}
                        @else
                        {{ $property->latestRecord->value }}
                        @endif
                    </div>
                    <div class="h5" style="color: #686e73;">
                        {{$property->units}}
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <p class="">{{ucwords($property->nick_name)}}</p>
    </div>
</div>