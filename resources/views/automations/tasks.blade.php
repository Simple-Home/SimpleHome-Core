<div class="automation-content">
    <div class="row">
        <div class="col mb-3">
            <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start mb-2"
                data-url="{{ route('automations.propertie.selection') }}" data-automation-type="{{ $automationType }}">
                <i class="fas fa-toggle-on pr-2 me-2" aria-hidden="true"></i>Set Device State
            </button>
            <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                data-url="#">
                <i class="fas fa-hourglass-half pr-2 me-2" aria-hidden="true"></i>Delay
            </button>
        </div>
    </div>
</div>
