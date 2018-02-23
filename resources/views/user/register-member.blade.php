@extends('layouts.joli.app')
<?php $page_title = 'Register New Member'; ?>
@section('content')
{{-- <div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Register New Member</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="form-horizontal" method="post" action="{{ url('user/register-member') }}">
      {{ csrf_field() }}
      @if(Auth::guard('admin')->check())
      <input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
      @else
      <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
      @endif
      <div class="box-body">
        <div class="form-group">
          <label for="username" class="col-sm-2 control-label" >Username</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="username" placeholder="Username">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Password</label>

          <div class="col-sm-10">
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
        </div>

        <div class="form-group">
          <label  class="col-sm-2 control-label">Re-Type Password</label>

          <div class="col-sm-10">
            <input type="password" class="form-control" name="password_confirmation"  placeholder="Re-Type Password">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Email</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="email" placeholder="Email">
          </div>
        </div>

        <div class="form-group">
          <label  class="col-sm-2 control-label">Mobile No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="mobile_no" placeholder="Mobile No" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Introducer</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="introducer" value="{{ Auth::guard('web')->user()->username }}">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">Save</button>
      </div>
      <!-- /.box-footer -->
    </form>
  </div>
  <!-- /.box -->
</div> --}}
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
  <form class="form-horizontal" method="post" action="{{ url('user/register-member') }}">
  {{ csrf_field() }}
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
            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
            <input class="form-control" type="text" name="mobile_no">
          </div>
          {{-- <span class="help-block">This is sample of text field</span> --}}
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Introducer</label>
        <div class="col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
            <input class="form-control" type="text" name="introducer" value="{{ Auth::guard('web')->user()->username }}">
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
        <button class="btn btn-primary pull-right">Submit</button>
      </div>
    </div>
  </form>
</div>
@endsection