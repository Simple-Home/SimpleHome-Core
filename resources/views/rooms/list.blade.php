@extends('layouts.app')

@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($rooms) && count($rooms) > 0)
            <div class="card">
                <div class="card-header">{{ __('Rooms List') }}</div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">name</th>
                                <th scope="col">is Default</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                            <tr>
                                <td>{{$room->name}}</td>
                                <td>{{$room->default}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <p class="text-center">{{ __('Nothing Found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
