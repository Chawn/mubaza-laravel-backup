@if(\Session::has('message'))
    <div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;{{ \Session::get('message') }}</div>
@endif
@if($errors->has())
    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;{{ $errors->first() }}</div>
@endif