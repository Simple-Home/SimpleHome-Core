<div class="card m-2 p-2" style="height: 100px">
    <div class="row">
        <div class="col my-auto">
            <a class="h2" href=" {{ route('properties_detail', $property->id) }}">
                <i class="fas {{$property->icon}}"></i>
            </a>
        </div>
        <div class="col">
            <p class="text-right m-0 h3">
                @if(View::exists('control.components.types.' . $property->type))
                @include('control.components.types.' . $property->type, $property)
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
        <div class="col">
            <p class="m-0">{{ucwords($property->nick_name)}}</p>
        </div>
    </div>
</div>