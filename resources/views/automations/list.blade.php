@extends('layouts.app')
@section('pageTitle', trans('simplehome.automations.list.pageTitle') )
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h2>{{ __('simplehome.automations.list.pageTitle') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
    <p class="text-center">{{ __('simplehome.automations.notFound') }}</p>
</div>
@endsection
