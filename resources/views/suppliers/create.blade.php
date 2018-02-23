@extends('layouts.homer.app')
<?php $page_title = 'Supplier'; ?>
@section('content')
<div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Supplier</h3>
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
    <form class="form-horizontal" method="post" action="{{ url('suppliers') }}">
      {{ csrf_field() }}
      @if(Auth::guard('admin')->check())
      <input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
      @else
      <input type="hidden" name="user_id" value="{{ Auth::guard('user')->user()->id }}">
      @endif
      <div class="box-body">
        <div class="form-group">
          <label for="company_name" class="col-sm-2 control-label" >Company Name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="street" class="col-sm-2 control-label">Street</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="street" id="street" placeholder="Street" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="postcode" class="col-sm-2 control-label">Postcode</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode">
          </div>
        </div>

        <div class="form-group">
          <label for="city" class="col-sm-2 control-label">City</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="city" id="city" placeholder="City" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="state" class="col-sm-2 control-label">State</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="state" id="state" placeholder="State" style="text-transform: capitalize">
          </div>
        </div>

        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Country</label>
          <div class="col-sm-10">
            <select name="country" class="form-control">
              <option value="Malaysia">Malaysia</option>
              <option value="Singapore">Singapore</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Thailand">Thailand</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="telephone_no" class="col-sm-2 control-label">Telephone No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="telephone_no" id="telephone_no" placeholder="Telephone No">
          </div>
        </div>

        <div class="form-group">
          <label for="fax_no" class="col-sm-2 control-label">Fax No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="fax_no" id="fax_no" placeholder="Fax No">
          </div>
        </div>

        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
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