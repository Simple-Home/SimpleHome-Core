@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h2>{{ __('Automations') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
    <p class="text-center">{{ __('No Automations Found, This feature has not been created.') }}</p>
</div>
@endsection
