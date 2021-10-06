<!-- Full screen modal -->
<div class="modal" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.notification') }}</h5>
                <div class="btn-group">
                    <a data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="btn btn-primary dropdown-item" href="{{route('notifications.read', ['notification_id' => 'all'])}}">
                                readAll
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-primary dropdown-item" href="{{route('notifications.delete', ['notification_id' => 'all'])}}">
                                deleteAll
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach (Auth::user()->notifications as $notification)
                <div class="card alert-{{$notification->data['type']}} mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-right text-nowrap">
                                <div class="d-flex justify-content-start">
                                    <div>
                                        @if(!empty($notification->data))
                                        <div class="h3 mb-0">
                                            {{$notification->data['title']}}
                                        </div>
                                        @endif
                                        <div class="p" style="color: #686e73;">
                                            {{$notification->created_at->diffForHumans()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="p" href="{{route('notifications.delete', ['notification_id' => $notification->id])}}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>

                        @if(empty($notification->read_at))
                        <a href="{{route('notifications.read', ['notification_id' => $notification->id])}}">mark as read</a>
                        @endif
                        @if(!empty($notification->data))
                        <p>{{$notification->data['message']}}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>