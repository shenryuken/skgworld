@extends('layouts.joli.app')
{{-- Page title --}}
<?php $page_title = 'Admins - Update Detail'; ?>
@section('content')
<div class="col-md-12">
  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
    @endif  
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif
    @if ($message = Session::get('fail'))
      <div class="alert alert-danger">
        <p>{{ $message }}</p>
      </div>
    @endif         
  <form class="form-horizontal" method="post" action="{{ route('admin.update', $admin->id) }}">
	  {{csrf_field()}}
	  <input name="_method" type="hidden" value="PUT">
  
  <div class="panel panel-default">
    <div class="panel-heading ui-draggable-handle">
      <h3 class="panel-title"><strong>Update</strong></h3>
      <ul class="panel-controls">
        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
      </ul>
    </div>
    <div class="panel-body">
      
      <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Username</label>
        <div class="col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input class="form-control" type="text" name="username" value="{{$admin->username}}">
          </div>
          {{-- <span class="help-block">This is sample of text field</span> --}}
        </div>
      </div>
     
      <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Email</label>
        <div class="col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
            <input class="form-control" type="text" name="email" value="{{$admin->email}}">
          </div>
          {{-- <span class="help-block">This is sample of text field</span> --}}
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Mobile No</label>
        <div class="col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
            <input class="form-control" type="text" name="mobile_no" value="{{$admin->mobile_no}}">
          </div>
          {{-- <span class="help-block">This is sample of text field</span> --}}
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Security Code</label>
        <div class="col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
            <input class="form-control" type="password" name="security_code" placeholder="Security Code Here">
          </div>
          {{-- <span class="help-block">This is sample of text field</span> --}}
        </div>
      </div>

    </div>
    <div class="panel-footer">
      {{-- <button class="btn btn-default">Clear Form</button> --}}
      <button class="btn btn-primary pull-right" type="submit">Update</button>
    </div>
    </div>
  </form>
  
</div>
@endsection