<div class="btn btn-info p-1">
    <a href="#" class="btn btn-primary"
        data-ajax-action-loader="{{ route('automations.run', ['automation_id' => $automation->id]) }}">
        <i class="fas fa-play"></i>
    </a>
    <a href="#" data-form-id="automatonForm"
        data-form-url="{{ route('automations.edit', ['automation_id' => $automation->id]) }}" class="btn btn-primary"
        name="automation-edit">
        <i class="fas fa-pen"></i>
    </a>
    <a href="{{ route('automations.remove', ['automation_id' => $automation->id]) }}" class="btn btn-danger">
        <i class="fas fa-trash"></i>
    </a>
</div>
{{-- onclick = "location.href='';"
    style = "cursor: pointer;" --}}
