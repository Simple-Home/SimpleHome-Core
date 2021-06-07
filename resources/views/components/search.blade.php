<form action="{{route(str_replace("list", "search", Route::currentRouteName()))}}" method="GET">
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col mb-4 col-md-10">
            <input class="form-control" value="{{ app('request')->input('search') }}" type="search" name="search" placeholder="{{ __('web.search') }}" aria-label="{{ __('web.search') }}" required>
        </div>
        <div class="col mb-4 col-md-2">
            <button class="btn btn-block btn-outline-success" type="submit">{{ __('web.search') }}</button>
        </div>
    </div>
</form>
