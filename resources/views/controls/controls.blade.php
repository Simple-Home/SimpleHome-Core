@if(!empty($propertyes) && count($propertyes) > 0)
<div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    @foreach ($propertyes as $property)
    <div class="col-lg-2 col-md-4 col">
        @include('controls.components.item', $property)
    </div>
    @endforeach
</div>
@else
<p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
@endif