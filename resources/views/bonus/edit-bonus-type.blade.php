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
    {{ Form::model($bonus_type, array('route' => array('bonus_types.update', $bonus_type->id),'id' => 'validateSubmitForm', 'class' => 'form-horizontal', 'method' => 'PUT')) }}
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
            <input type="text" class="form-control" name="name" value="{{ $bonus_type->name }}" style="text-transform: capitalize">
          </div>
        </div>
		<!-- Value -->
        <div class="form-group">
          <label for="value" class="col-sm-2 control-label" >Value</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="value" value="{{ $bonus_type->value }}" >
          </div>
        </div>
        <!-- Value Type-->
        <div class="form-group">
          <label class="col-sm-2 control-label">Value Type</label>
          <div class="col-sm-10">
            <select name="value_type" class="form-control">
              <option value="Percentage" {{ $bonus_type->value_type == 'Percentage' ? 'selected' :'' }} >Percentage</option>
              <option value="MYR" {{ $bonus_type->value_type == 'MYR' ? 'selected' :'' }} >MYR</option>
              <option value="Point" {{ $bonus_type->value_type == 'Point' ? 'selected' :'' }} >Point</option>
            </select>
          </div>
        </div>
		<!-- Rank -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Rank</label>
          <div class="col-sm-10">
            <select name="rank" class="form-control">
              <option value="0">Please Select ..</option>
              <option value="1" {{ $bonus_type->rank == 1 ? 'selected' :'' }} >Customer</option>
              <option value="2" {{ $bonus_type->rank == 2 ? 'selected' :'' }} >Loyal Customer</option>
              <option value="3" {{ $bonus_type->rank == 3 ? 'selected' :'' }} >Manager Officer</option>
              <option value="4" {{ $bonus_type->rank == 4 ? 'selected' :'' }} >Distributor Officer</option>
              <option value="5" {{ $bonus_type->rank == 5 ? 'selected' :'' }} >Senior Distributor Officer</option>
            </select>
          </div>
        </div>
        <!-- Term -->
        <div class="form-group">
          <label for="term" class="col-sm-2 control-label" >Term</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="term" value="{{ $bonus_type->term }}">
          </div>
        </div>
        <!-- Duration -->
        <div class="form-group">
          <label for="duration" class="col-sm-2 control-label" >Duration</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="duration" value="{{ $bonus_type->duration }}">
          </div>
        </div>
        <!-- Duration Type-->
        <div class="form-group">
          <label class="col-sm-2 control-label">Duration Type</label>
          <div class="col-sm-10">
            <select name="duration_type" class="form-control">
              <option value="0">Please Select ..</option>
              <option value="Day" {{ $bonus_type->duration_type == 'Day' ? 'selected' :'' }} >Day</option>
              <option value="Month" {{ $bonus_type->duration_type == 'Month' ? 'selected' :'' }} >Month</option>
              <option value="Year" {{ $bonus_type->duration_type == 'Year' ? 'selected' :'' }} >Year</option>
            </select>
          </div>
        </div>
        <!-- Description -->
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label" >Description</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="description" value="{{ $bonus_type->description }}">
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