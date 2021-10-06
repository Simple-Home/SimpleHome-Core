@if(!empty($notifications) && count($notifications) > 0)
@foreach($notifications as $notification)
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
            <div id="notification-control-load" class="p" data-url="{{route('notifications.delete', ['notification_id' => $notification->id])}}">
                <i class="fas fa-trash"></i>
            </div>
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
@else
<p class=" text-center">{{ __('simplehome.notifications.notFound') }}</p>
@endif