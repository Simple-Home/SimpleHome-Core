<form id="search" action="{{ route(str_replace('index', 'ajax.search', Route::currentRouteName())) }}" method="GET">
    <div class="d-flex mb-2">
        <div class="flex-grow-1 me-1">
            <input class="form-control" value="{{ app('request')->input('search') }}" type="search" name="search"
                placeholder="{{ __('simplehome.search') }}" aria-label="{{ __('simplehome.search') }}" required>
        </div>
        <div>
            <button class="btn btn-block btn-outline-success h-100" type="submit">
                <i class="fas fa-search"></i>
                <div class="d-none d-md-inline">{{ __('simplehome.search') }}</div>
            </button>
        </div>
    </div>
</form>
