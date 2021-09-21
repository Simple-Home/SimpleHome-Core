@if ($message = Session::get('success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div><i class="fas fa-check mr-3"></i>{{ $message }}</div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div><i class="fas fa-exclamation mr-3"></i>{{ $message }}</div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div><i class="fas fa-exclamation mr-3"></i>{{ $message }}</div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div><i class="fas fa-info mr-3"></i>{{ $message }}</div>
</div>
@endif