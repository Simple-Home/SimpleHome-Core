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
            <input class="form-control" required="required" name="automation_id" type="hidden" id="automation_id"
                value="{{ $automation['automation_id'] }}">
            <div class="mt-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="automation_notifiy" name="automation_notifiy"
                        {{ $automation['automation_notifiy'] ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="automation_notifiy">{{ __('simplehome.notifications.enable') }}</label>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="form-label required">{{ __('simplehome.trigger') }}</label>
            <table class="table">
                <tbody>
                    @if (!empty($automation['automation_triggers']) && count($automation['automation_triggers']) > 0 && is_array($automation['automation_triggers']))
                        @foreach ($automation['automation_triggers'] as $trigger_key => $trigger)
                            <tr scope="row">
                                <th scope="col">
                                    {{ $trigger['name'] }}
                                </th>
                                @if ($trigger['type'] == 'location')
                                    <td>
                                        <select class="form-select" aria-label="Default select example"
                                            name="automation_triggers[{{ $trigger_key }}][operator]">
                                            <option value="=" {{ $trigger['operator'] == '=' ? 'selected' : '' }}>
                                                (equal)</option>
                                            <option value="!=" {{ $trigger['operator'] == '!=' ? 'selected' : '' }}>
                                                (not equal)</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example"
                                            name="automation_triggers[{{ $trigger_key }}][value]">
                                            @foreach ($places as $place)
                                                <option value="{{ $place->id }}" selected>{{ $place->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @else
                                    <td scope="col">
                                        <select class="form-select" aria-label="Default select example"
                                            name="automation_triggers[{{ $trigger_key }}][operator]">
                                            <option value="=" {{ $trigger['operator'] == '=' ? 'selected' : '' }}>
                                                (equal)</option>
                                            <option value="<" {{ $trigger['operator'] == '<' ? 'selected' : '' }}>
                                                (less)</option>
                                            <option value=">" {{ $trigger['operator'] == '>' ? 'selected' : '' }}>
                                                (great)</option>
                                            <option value="!=" {{ $trigger['operator'] == '!=' ? 'selected' : '' }}>
                                                (not equal)</option>
                                        </select>
                                    </td>
                                    <td scope="col">
                                        <input class="form-control" type="text"
                                            name="automation_triggers[{{ $trigger_key }}][value]"
                                            value="{{ $trigger['value'] }}" id="text-input-{{ $trigger_key }}"
                                            placeholder="{{ $trigger['value'] }}" maxlength="5" required>
                                    </td>
                                    <td scope="col" class="text-end">
                                        {{ $trigger['units'] }}
                                    </td>
                                @endif
                                <td scope="col" class="text-end">
                                    @if ($loop->index > 0)
                                        <a onclick="deleteRow(this)" href="#" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr scope="row">
                            <td scope="col">
                                Manual
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="row">
            <label class="form-label required">{{ __('simplehome.actions') }}</label>
            <table class="table">
                <tbody>
                    @if (!empty($automation['automation_actions']) && count((array) $automation['automation_actions']) > 0)
                        @foreach (((array) $automation['automation_actions']) as $propery_id => $action)
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
                                    {{ $action['units'] }}
                                </td>
                                <td scope="col" class="text-end">
                                    @if ($loop->index > 0)
                                        <a onclick="deleteRow(this)" href="#" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col mb-3">
                <button class="form-control" type="submit">{{ __('simplehome.finish') }}</button>
            </div>
        </div>
    </form>
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
                    url: '{{ route($nextUrl) }}',
                    data: form.serialize(),
                    success: function(msg) {
                        $("div.automation-content").replaceWith(msg);
                    }
                });
            });
        });
    </script>
</div>
