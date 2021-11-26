@if (!empty($automations) && count($automations) > 0)
    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
        @foreach ($automations as $automation)
            <div class="col-lg-4 col-md-6 col-12 p-0">
                @include('automations.components.automation', $automation)
            </div>
        @endforeach
    </div>
@else
    <p class="text-center">{{ __('simplehome.automations.nothing') }}</p>
@endif
