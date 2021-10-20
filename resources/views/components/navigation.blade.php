<li class="nav-ite">
    <a href="{{ route('controls.list') }}"
        class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'controls') > -1 ? 'active' : '' }} text-center ">
        <i class="fa fa-home"></i><span class="d-none ms-md-2 d-md-inline">Rooms</span>
    </a>
</li>
<li class="nav-item">
    <a id='notification-button' onClick="$('#notifications').modal('toggle')"
        class="nav-link btn-sq position-relative text-center" data-url="{{ route('notifications.ajax.count') }}">
        <i class="fa fa-bell">
            <span
                class="notification-badge position-absolute top-0 p-1 bg-danger border border-light rounded-circle d-md-none">
                <span class="visually-hidden">New alerts</span>
            </span>
        </i>
        <span class="d-none ms-md-2 d-md-inline">Events</span>
        <span id="notification-count"
            class="notification-badge d-none btn-sq ms-md-2 badge rounded-pill bg-danger">#</span>
    </a>
</li>
<li class="nav-item btn-sq">
    <a href="{{ route('automations.index') }}"
        class="nav-link btn-sq {{ Route::currentRouteName() == 'automations.index' ? 'active' : '' }} text-center ">
        <i class="fa fa-clock m-auto"></i><span class="d-none ms-md-2 d-md-inline">Automations</span>

    </a>
</li>
<li>
    <a href="{{ route('system.profile') }}"
        class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'system') > -1 ? 'active' : '' }} text-center  btn-sq">
        <i class="fa fa-cog"></i></i><span class="d-none ms-md-2 d-md-inline">Settings</span>
    </a>
</li>

<script>
    /*function ajaxValueLoader(sourceUrl, target) {
        console.log("loading from: ", sourceUrl)
        $.ajax({
            start_time: new Date().getTime(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: sourceUrl,
            success: function(msg) {
                target.html(msg);
                console.log((new Date().getTime() - this.start_time) + ' ms');
            },
            timeout: 3000,
        });
    }
    var id = setInterval(function() {
        Fetch NOtification cout periodicaly
    }, 30000); // 30 seconds*/
</script>
<style>
    .btn-sq {
        width: 50px !important;
        height: 50px !important;
    }

    @media (min-width: 768px) {
        .btn-sq {
            width: auto !important;
        }
    }

</style>
