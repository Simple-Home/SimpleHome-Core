@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('simplehome.room.create') }}</div>

                <div class="card-body">
                    {!! form($roomForm) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
