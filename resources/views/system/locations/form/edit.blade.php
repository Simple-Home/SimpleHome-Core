<div class="modal-body">
    <!-- Modal -->
    <form id="private-token" class="" method="POST"
        action="{{ isset($location) ? route('system.locations.save', ['location_id' => $location->id]) : route('system.locations.new') }}">
        @csrf

        <div class="mb-3">
            <div class="input-group">
                <button id="positionIconOpener" class="input-group-text">
                    <i class="fas {{ isset($location) ? $location->icon : 'fa-warehouse' }}"></i>
                </button>
                <input type="text" class="form-control" placeholder="{{ __('name') }}"
                    value="{{ isset($location) ? $location->name : '' }}" name="postitionName" required>
            </div>
        </div>

        <div class="mb-3">
            <div id="positionIcon" class="btn-info" name="positionIcon"
                data-icon="{{ isset($location) ? $location->icon : 'fa-warehouse' }}">
                <input type="hidden" name="positionIcon"
                    value="{{ isset($location) ? $location->icon : 'fa-warehouse' }}">
            </div>
        </div>

        <div class="mb-3">
            <div id="map" class="map form-control p-0" tabindex="0"></div>
            <style>
                .map {
                    height: 400px;
                    width: 100%;
                }

            </style>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="postitionLat" id="postitionLat"
                        placeholder="{{ __('simplehome.locations.lattitude') }}"
                        value="{{ isset($location) ? $location->position[0] : '' }}" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="postitionLong" id="postitionLong"
                        placeholder="{{ __('simplehome.locations.longtitude') }}"
                        value="{{ isset($location) ? $location->position[1] : '' }}" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="col-auto">
                <label for="positionRadius" class="visually-hidden"></label>
                <input type="number" class="form-control" name="positionRadius" id="positionRadius"
                    placeholder="{{ __('simplehome.locations.radius') }} (m)"
                    value="{{ isset($location) ? $location->radius : '' }}" required>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">{{ __('simplehome.create') }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('simplehome.close') }}</button>
    </form>
</div>
