@extends('layouts.app')

@section('content')
<div class="container">
    @include('components.search')
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($rooms) && count($rooms) > 0)
            <div class="row">
                <div class="col">
                    <h2>{{ __('Rooms List') }}</h2>
                </div>
                <div class="col">
                    <div class="float-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">+</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">name</th>
                            <th style="width: 10%">is Default</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{$room->name}}</td>
                            <td>
                                @if ($room->default)
                                <a href="/test" class="btn btn-primary"><i class="fas fa-toggle-on"></i></a>
                                @else
                                <a href="/test" class="btn btn-primary"><i class="fas fa-toggle-off"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center">{{ __('Nothing Found') }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            test
        </div>
    </div>
</div>

@endsection
