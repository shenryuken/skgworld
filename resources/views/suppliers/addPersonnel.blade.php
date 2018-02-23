@extends('layouts.homer.app')
<?php $page_title = 'Add Contact'; ?>
@section('content')
<div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">{{ $company->company_name }} | Add Contact</h3>
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
    <form class="form-horizontal" method="post" action="{{ url('supplier/addContact') }}">
      {{ csrf_field() }}
      <input type="hidden" name="supplier_id" value="{{$company->id}}">
      <div class="box-body">
        <div class="form-group">
          <label for="full_name" class="col-sm-2 control-label" >Full Name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Contact Name" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="department" class="col-sm-2 control-label">Department</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="department" id="department" placeholder="Department" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="position" class="col-sm-2 control-label">Position</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="position" id="position" placeholder="Position">
          </div>
        </div>

        <div class="form-group">
          <label for="mobile_no" class="col-sm-2 control-label">Mobile No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="phone_no" class="col-sm-2 control-label">Telephone No (Office)</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Telephone No (Office)" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="ext_no" class="col-sm-2 control-label">Ext. No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="ext_no" id="ext_no" placeholder="Extention No" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="email" id="email" placeholder="Extention No" >
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
</div>
@endsection