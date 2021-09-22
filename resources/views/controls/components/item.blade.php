<div class="card p-2 m-0" style="height: 100px">
    <div class="container p-0">
        <div class="d-flex justify-content-between">
            <a class="h2" href="{{ route('controls.detail', $property->id) }}">
                <i class="fas {{$property->icon}}"></i>
            </a>
            <div class="text-right text-nowrap h3">
                <div>
                    @if(View::exists('controls.components.types.' . $property->type))
                    @include('controls.components.types.' . $property->type, $property)
                    @else
                    @if (isset($property->last_value))
                    @if(is_numeric($property->last_value->value))
                    {{ round($property->last_value->value, 2) }} {{$property->units}}
                    @else
                    {{ $property->last_value->value }} {{$property->units}}
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <p class="">{{ucwords($property->nick_name)}}</p>
    </div>
</div>