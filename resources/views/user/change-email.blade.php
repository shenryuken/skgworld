@extends('layouts.joli.app')
<?php $page_title = 'Change Email'; ?>
@section('content')
<div class="row">
  <div class="col-md-12">
      <!-- form start -->
      @if (Session::get('success'))
          <div class="alert alert-success">{{ Session::get('success') }}</div>
      @endif
      @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif
      <form class="form-horizontal" method="post" action="{{ url('change-email') }}">
        <div class="panel panel-default">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Change Email</strong></h3>
            <ul class="panel-controls">
                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
            </ul>
        </div>
        <div class="panel-body">  
          <div class="form-group">
            <label for="old_email" class="col-sm-2 control-label">Old Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="old_email" name="email" value="{{Auth::user()->email}}" placeholder="Old Email">
            </div>
          </div>

          <div class="form-group">
            <label for="new_email" class="col-sm-2 control-label">New Email</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" name="new_email" id="new_email" placeholder="Your New Email">
            </div>
          </div>

          <div class="form-group">
            <label for="new_email_confirmation" class="col-sm-2 control-label">Confirm New Email</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" name="new_email_confirmation" id="new_email_confirmation" placeholder="New Email Again">
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="panel-footer">
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
    <!-- /.box -->
  </div>
</div>

@endsection