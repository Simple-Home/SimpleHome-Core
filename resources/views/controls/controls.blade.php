@if (!empty($propertyes) && count($propertyes) > 0)
    <div class="row row-cols-3 row-cols-lg-5 g-1">
        @foreach ($propertyes as $property)
            <div class=" col col-lg-2 col-md-4">
                @include('controls.components.item', $property)
            </div>
        @endforeach
    </div>
@else
    <p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
@endif
