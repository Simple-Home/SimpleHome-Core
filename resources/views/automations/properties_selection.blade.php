<div class="automation-content">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                @progressbar(3, 6)
            </div>
        </div>
    </div>
    <form id="properties-selection" class="needs-validation">
        <div class="row">
            <div class="col mb-3">
                <input type="hidden" name="automation_type" value="{{ $automationType }}" />

                @if (!empty($propertyes) && count($propertyes) > 0)
                    @foreach ($propertyes as $property)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="properties_selection[]"
                                value="{{ $property->id }}" id="checkbox-{{ $property->id }}">
                            <label class="form-check-label" for="checkbox-{{ $property->id }}">
                                {{ $property->nick_name }}
                            </label>
                        </div>
                    @endforeach
                @else
                    <p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
                @endif

                <div class="invalid-feedback">
                    {{ __('simplehome.nothing.selected') }}.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <button class="form-control" type="submit">Next</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('form#properties-selection').on('submit', function(e) {
            var form = $('form#properties-selection');
            if (form.serialize().indexOf("properties_selection") !== -1) {
                console.log(form.serialize())
                form.find("div.invalid-feedback").addClass("d-none");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    @if ($automationType == 'manual')
                        url: '{{ route('automations.propertie.set') }}',
                    @else
                        url: '{{ route('automations.propertie.rules') }}',
                    @endif
                    data: form.serialize(),
                    success: function(msg) {
                        $("div.automation-content").replaceWith(msg);
                    }
                });
            } else {
                console.log("[automationCreationWizard]-no Value Selected");
                form.find("div.invalid-feedback").addClass("d-inline");
            }
            e.preventDefault();

        });
    });
</script>
