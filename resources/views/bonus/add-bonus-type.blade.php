@extends('layouts.homer.app')

<?php $page_title = 'Product Category'; ?>
@section('content')
<div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Add New Category</h3>
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
    <form class="form-horizontal" method="post" action="{{ url('bonus_types') }}">
      {{ csrf_field() }}
      @if(Auth::guard('admin')->check())
      	<input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
      @else
      	<h3>You do not have permission for this action.</h3>
      @endif
      <div class="box-body">
      	<!-- Name -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label" >Name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="Bonus Name" style="text-transform: capitalize">
          </div>
        </div>
		<!-- Value -->
        <div class="form-group">
          <label for="value" class="col-sm-2 control-label" >Value</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="value" placeholder="0" >
          </div>
        </div>
        <!-- Value Type-->
        <div class="form-group">
          <label class="col-sm-2 control-label">Value Type</label>
          <div class="col-sm-10">
            <select name="value_type" class="form-control">
              <option value="0">Please Select ..</option>
              <option value="Pecentage">Pecentage</option>
              <option value="MYR">MYR</option>
              <option value="Point">Point</option>
            </select>
          </div>
        </div>
		<!-- Rank -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Rank</label>
          <div class="col-sm-10">
            <select name="rank" class="form-control">
              <option value="0">Please Select ..</option>
            @foreach($ranks as $rank)
              <option value="{{ $rank->id }}">{{ $rank->name }}</option>
            @endforeach
            </select>
          </div>
        </div>
        <!-- Term -->
        <div class="form-group">
          <label for="term" class="col-sm-2 control-label" >Term</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="term">
          </div>
        </div>
        <!-- Duration -->
        <div class="form-group">
          <label for="duration" class="col-sm-2 control-label" >Duration</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="duration" >
          </div>
        </div>
        <!-- Duration Type-->
        <div class="form-group">
          <label class="col-sm-2 control-label">Duration Type</label>
          <div class="col-sm-10">
            <select name="duration_type" class="form-control">
              <option value="0">Please Select ..</option>
              <option value="Day">Day</option>
              <option value="Month">Month</option>
              <option value="Year">Year</option>
            </select>
          </div>
        </div>
        <!-- Description -->
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label" >Description</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="description" >
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
</div>
@endsection