@extends('layouts.app')
@section('title', trans('simplehome.home.pageTitle'))

@section('subnavigation')
@include('controls.components.subnavigation', $rooms)
@endsection

@section('content')
@if(!empty($propertyes) && count($propertyes) > 0)
<div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    @foreach ($propertyes as $property)
    <div class="col-lg-2 col-md-4 col">
        @include('controls.components.item', $property)
    </div>
    @endforeach
</div>
@else
<p class=" text-center">{{ __('simplehome.controls.notFound') }}</p>
@endif

<!-- Full screen modal -->
<div class="modal" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.notification') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach (Auth::user()->notifications as $notification)
                <div class="card mb-3">
                    <div class="card-body">
                        {{$notification->created_at}}
                        @if(!empty($notification->data))
                        <h1>{{$notification->data['title']}}</h1>
                        @endif

                        @if(empty($notification->read_at))
                        <a href="{{route('notifications.read', ['notification_id' => $notification->id])}}">mark as read</a>
                        @endif

                        <a href="{{route('notifications.delete', ['notification_id' => $notification->id])}}">delete</a>

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



@endsection

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('simplehome.room.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! form($roomForm) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>