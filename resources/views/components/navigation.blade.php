<li class="nav-item">
    <a href="{{ route('controls.list') }}"
        class="nav-link {{ strpos(Route::currentRouteName(), 'controls') > -1 ? 'active' : '' }}">
        <i class="fa fa-home"></i><span class="d-none ms-md-2 d-md-inline">Rooms</span>
    </a>
</li>
<li class="nav-item">
    <a onClick="$('#notifications').modal('toggle')" class="nav-link position-relative">
        <i class="fa fa-bell">
            @if (($notificationCount = auth()->user()->notifications->Count()) > 0)
                <span
                    class="position-absolute top-0 p-1 bg-danger border border-light rounded-circle d-inline d-md-none">
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </i>
        <span class="d-none ms-md-2 d-md-inline">Events</span>
        @if ($notificationCount > 0)
            <span class="d-none ms-md-2 d-md-inline badge rounded-pill bg-danger">{{ $notificationCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('automations.list') }}" class="nav-link">
        <i class="fa fa-clock"></i><span class="d-none ms-md-2 d-md-inline">Automations</span>
    </a>
</li>
<li>
    <a href="{{ route('system.profile') }}"
        class="nav-link {{ strpos(Route::currentRouteName(), 'system') > -1 ? 'active' : '' }}">
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
