<div class="automation-content">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                @progressbar(4, 6)
            </div>
        </div>
    </div>
    <form id="properties-selection">
        <div class="row">
            <div class="col mb-3">
                <table class="table">
                    <tbody>
                        @if (!empty($propertyes) && count($propertyes) > 0)
                            @foreach ($propertyes as $property)
                                <tr>
                                    <th scope="col">
                                        {{ $property->nick_name }}
                                    </th>
                                    <td scope="col">
                                        <input class="form-control" type="text"
                                            name="property[{{ $property->id }}][value]" value=""
                                            id="text-input-{{ $property->id }}"
                                            placeholder="{{ $property->latestRecord->value }}" maxlength="5" required>
                                    </td>
                                    <td scope="col" class="text-end">
                                        <a onclick="deleteRow(this)" href="#" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
                        form.replaceWith(msg);
                    }
                });
            });
        });
    </script>
</div>
