<div class="automation-content">
    <form id="properties-selection">
        <div class="row">
            <div class="col mb-3">
                <input type="hidden" name="automation_type" value="{{ $automationType }}"/>

                @if (!empty($propertyes) && count($propertyes) > 0)
                    @foreach ($propertyes as $property)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="properties_selection[]" value="{{ $property->id }}"
                                id="checkbox-{{ $property->id }}">
                            <label class="form-check-label" for="checkbox-{{ $property->id }}">
                                {{ $property->nick_name }}
                            </label>
                        </div>
                    @endforeach
                @else
                    <p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
                @endif
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
            console.log(form.serialize())
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                @if($automationType == "manual")
                    url: '{{route("automations.propertie.set")}}',
                @else
                    url: '{{route("automations.propertie.rules")}}',
                @endif
                data: form.serialize(),
                success: function(msg) {
                    form.replaceWith(msg);
                }
            });
        });
    });
</script>
