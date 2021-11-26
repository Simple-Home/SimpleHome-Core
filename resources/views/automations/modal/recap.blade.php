<div class="automation-content">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                @progressbar(5, 6)
            </div>
        </div>
    </div>
    <form id="recap">
        <div class="mb-3">
            <label for="automation_name" class="form-label required">{{ __('simplehome.name') }}</label>
            <input class="form-control" required="required" maxlength="255" name="automation_name" type="text"
                id="automation_name" value="{{ $automation['automation_name'] }}">
        </div>
        <div class="row">
            <label class="form-label required">{{ __('simplehome.trigger') }}</label>
            <table class="table">
                <tbody>
                    @if (!empty($automation['automation_triggers']) && count($automation['automation_triggers']) > 0)
                        @foreach ($automation['automation_triggers'] as $trigger_key => $trigger)
                            <tr scope="row">
                                <th scope="col">
                                    {{ __('Trigger_') . $trigger_key }}
                                </th>
                                <td scope="col" class="w-100">
                                    <input class="form-control" type="text" name="automation_triggers[]"
                                        value="{{ $trigger }}" id="text-input-{{ $trigger_key }}"
                                        placeholder="{{ $trigger }}" maxlength="5" required>
                                </td>
                                <td scope="col" class="text-end">
                                    <a onclick="deleteRow(this)" href="#" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>


        </div>
        <div class="row">
            <label class="form-label required">{{ __('simplehome.actions') }}</label>
            <table class="table">
                <tbody>
                    @if (!empty($automation['automation_actions']) && count($automation['automation_actions']) > 0)
                        @foreach ($automation['automation_actions'] as $propery_id => $action)
                            <tr scope="row">
                                <th scope="col">
                                    {{ $action['name'] }}
                                </th>
                                <td scope="col" class="w-100">
                                    <input class="form-control" type="text"
                                        name="automation_actions[{{ $propery_id }}][value]"
                                        value="{{ $action['value'] }}" id="text-input-{{ $propery_id }}"
                                        placeholder="{{ $action['value'] }}" maxlength="5" required>
                                </td>
                                <td scope="col" class="text-end">
                                    <a onclick="deleteRow(this)" href="#" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
        $('form#recap').on('submit', function(e) {
            var form = $('form#recap');
            console.log(form.serialize())
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route('automations.propertie.finish') }}',
                data: form.serialize(),
                success: function(msg) {
                    $("div.automation-content").replaceWith(msg);
                }
            });
        });
    });
</script>
