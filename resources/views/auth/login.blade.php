@extends('layouts.full')

@section('content')
<form class="form-horizontal form-simple" action="{{url('/')}}/didLogin" method="post" novalidate>
    {{csrf_field()}}
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <fieldset class="form-group position-relative has-icon-left mb-2">
        <input type="text" class="form-control form-control-lg" id="api-key" placeholder="Api key" required name="api_key">
        <div class="form-control-position">
            <i class="fa fa-key"></i>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Login</button>
</form>
@endsection
