@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
    Register Staff
    @parent
@stop
<?php $page_title = 'Register New Staff'; ?>
@section('content')

<div class="row">
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
    @if(Auth::guard('admin')->check())                       
    <form class="form-horizontal" method="post" action="{{ url('admin/register-staff') }}">
      {{ csrf_field() }}

      <input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">

      <div class="panel panel-default">
        <div class="panel-heading ui-draggable-handle">
          <h3 class="panel-title"><strong>Register</strong></h3>
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
                <input class="form-control" type="text" name="username">
              </div>
              {{-- <span class="help-block">This is sample of text field</span> --}}
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Password</label>
            <div class="col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                <input class="form-control" type="password" name="password">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Re-Type Password</label>
            <div class="col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                <input class="form-control" type="password" name="password_confirmation">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Email</label>
            <div class="col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                <input class="form-control" type="text" name="email">
              </div>
              {{-- <span class="help-block">This is sample of text field</span> --}}
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Mobile No</label>
            <div class="col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-mobile"></span></span>
                <input class="form-control" type="text" name="mobile_no">
              </div>
              {{-- <span class="help-block">This is sample of text field</span> --}}
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Role</label>
            <div class="col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                <select name="role" class="form-control">
                @foreach($roles as $role)
                  @if($role->name != 'Administrator')
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
                  @endif
                @endforeach
                </select>
              </div>
              {{-- <span class="help-block">This is sample of text field</span> --}}
            </div>
          </div>

          
          </div>
          <div class="panel-footer">
            {{-- <button class="btn btn-default">Clear Form</button> --}}
            <button class="btn btn-primary pull-right">Submit</button>
          </div>
        </div>
    </form>
    @else
      You don't have permission to this action!
    @endif
  </div> 
</div>

@endsection