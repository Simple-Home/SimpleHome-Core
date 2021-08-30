<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5>
                    <a href="{{ route('properties_detail', $property->id) }}">
                        <i class="fas {{$property->icon}}"></i>
                    </a>
                </h5>
            </div>
            <div class="col">
                <p class="text-right">
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
            <p>
                {{ucwords($property->nick_name)}}
            </p>
        </div>
    </div>
</div>