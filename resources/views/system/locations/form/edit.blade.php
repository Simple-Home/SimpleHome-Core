<div class="modal-body">
    <!-- Modal -->
    <form id="private-token" class="" method="POST"
        action="{{ isset($location) ? route('system.locations.save', ['location_id' => $location->id]) : route('system.locations.new') }}">
        @csrf

        <div class="col-auto">
            <div class="input-group">
                <span class="input-group-prepend">
                    <button id="positionIconOpener" class="btn btn-secondary">
                        <i class="fas {{ isset($location) ? $location->icon : 'fa-warehouse' }}"></i>
                    </button>
                </span>
                <input type="text" class="form-control" placeholder="Location Name"
                    value="{{ isset($location) ? $location->name : '' }}" name="postitionName" required>
            </div>
        </div>

        <div id="positionIcon" name="positionIcon"></div>

        <div id="map" class="map my-2" tabindex="0"></div>
        <style>
            .map {
                height: 400px;
                width: 100%;
            }

        </style>

        <div class="col-auto">
            <label for="positionRadius" class="visually-hidden"></label>
            <input type="number" class="form-control" name="positionRadius" id="positionRadius"
                placeholder="Radius (m)" value="{{ isset($location) ? $location->radius : '' }}" required>
        </div>

        <div class="col-auto">
            <label for="postitionLat" class="visually-hidden"></label>
            <input type="text" class="form-control" name="postitionLat" id="postitionLat" placeholder="Lat"
                value="{{ isset($location) ? $location->position[0] : '' }}" required>
        </div>

        <div class="col-auto">
            <label for="postitionLong" class="visually-hidden"></label>
            <input type="text" class="form-control" name="postitionLong" id="postitionLong" placeholder="long"
                value="{{ isset($location) ? $location->position[1] : '' }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </form>
</div>
