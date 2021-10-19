@foreach (['automations', 'scenes'] as $type)
    <li class="nav-item my-auto">
        <div class="nav-link subnavigation user-select-none" title="" data-automation-type="{{ $type }}"
            data-url="{{ route('automations.ajax.list', ['type' => $type]) }}">
            {{ __('simplehome.automations.' . $type) }}</div>
    </li>
@endforeach

<!-- Button trigger modal -->
<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#automatonForm"
    title="{{ __('simplehome.room.create') }}">
    <i class="fas fa-plus"></i>
</button>
