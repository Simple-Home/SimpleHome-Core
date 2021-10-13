<div class="card p-2 m-1">
    <div class="container p-0">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between">
                    <h2 class="text-decoration-none">{{ $automation->name }}</h2>
                    <div class="text-right text-nowrap">
                        <div class="d-flex justify-content-start">
                            @if ($automation->is_enabled)
                                <div class="control-relay h3 m-0"
                                    data-url="{{ route('automations.disable', ['automation_id' => $automation->id]) }}">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                            @else
                                <div class="control-relay h3 m-0"
                                    data-url="{{ route('automations.enable', ['automation_id' => $automation->id]) }}">
                                    <i class="fas fa-toggle-off"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col m-0">
                @if (!empty($automation->run_at))
                    <p class="text-decoration-none">{{ $automation->run_at->diffForHumans() }}</p>
                @endif
                <div class="d-flex justify-content-start">
                    @include('automations.components.controls', $automation)
                </div>
            </div>
        </div>
    </div>
</div>
