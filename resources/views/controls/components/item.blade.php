<div class="card p-2 m-1" style="height: 100px">
    <div class="container p-0">
        <div class="row">
            <div class="col my-auto">
                <a class="h2" href="{{ route('controls.detail', $property->id) }}">
                    <i class="fas {{$property->icon}}"></i>
                </a>
            </div>
            <div class="col text-right text-nowrap">
                <p class="m-0 h3">
                    @if(View::exists('controls.components.types.' . $property->type))
                    @include('controls.components.types.' . $property->type, $property)
                    @else
                    @if (is_numeric($property->last_value->value))
                    {{ round($property->last_value->value, 2) }}
                    @else
                    {{ $property->last_value->value }}
                    @endif
                    @endif
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col m-0">
                <p class="m-0">{{ucwords($property->nick_name)}}</p>
            </div>
        </div>
    </div>
</div>