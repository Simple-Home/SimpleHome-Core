@extends('layouts.app')
@section('pageTitle', trans('simplehome.properties.edit.pageTitle') )
@section('content')
<!-- Bootstrap-Iconpicker -->
<link rel="stylesheet" href="dist/css/bootstrap-iconpicker.min.css" />
<!-- Bootstrap-Iconpicker Bundle -->
<script type="text/javascript" src="dist/js/bootstrap-iconpicker.bundle.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Password change</div>
                <div class="card-body">
                    {!! form($propertyEditForm) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection