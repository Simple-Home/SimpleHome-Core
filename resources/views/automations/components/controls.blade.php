<div class="btn btn-info p-1">
    <a href="#" class="btn btn-primary">
        <i class="fas fa-play"></i>
    </a>
    <a href="" class="btn btn-primary">
        <i class="fas fa-redo"></i>
    </a>
    <a href="{{ route('automations.remove', ['automation_id' => $automation->id]) }}" class="btn btn-danger">
        <i class="fas fa-trash"></i>
    </a>
</div>
