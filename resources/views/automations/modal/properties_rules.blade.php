<div class="automation-content">
    <form id="properties-selection">
        <div class="row">
            <div class="col mb-3">
                <table class="table">
                    <tbody>
                        @if (!empty($propertyes) && count($propertyes) > 0)
                            @foreach ($propertyes as $property)
                                <tr>
                                    <th>
                                        {{ $property->nick_name }}
                                    </th>
                                    <td>
                                        <select class="form-select" aria-label="Default select example"
                                            name="property[{{ $property->id }}][operator]">
                                            <option value="=" selected>=</option>
                                            <option value="<">
                                                < </option>
                                            <option value=">"> > </option>
                                            <option value="!=">!=</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text"
                                            name="property[{{ $property->id }}][value]" value=""
                                            id="text-input-{{ $property->id }}"
                                            placeholder="{{ $property->latestRecord->value ?? '' }}" maxlength="5"
                                            required>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <button class="form-control" type="submit">Next</button>
            </div>
        </div>
    </form>
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
