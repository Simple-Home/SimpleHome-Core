<div class="card p-2 m-1">
    <div class="container p-0">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between">
                    <h2 class="text-decoration-none text-truncate">@if ($automation->is_locked) <i class="fas fa-lock me-1"></i> @endif {{ $automation->name }}
                    </h2>
                    <div class="text-right text-nowrap">
                        <div class="d-flex justify-content-start">
                            <div class="h3 m-0"
                                data-ajax-action-loader="{{ route('automations.toggle', ['automation_id' => $automation->id]) }}">
                                @if ($automation->is_enabled)
                                    <i class="fas fa-toggle-on"></i>
                                @else
                                    <i class="fas fa-toggle-off"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col m-0">
                {{-- TODO: add same feature like in detail of controle nice time to raw time --}}
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
