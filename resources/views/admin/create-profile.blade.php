@extends('layouts.homer.app')

{{-- Page title --}}
@section('title')
    Admin List
    @parent
@stop
<?php $page_title = 'Dashboard'; ?>
@section('content')

<div class="row">
    <div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Profile</h3>
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
    <form class="form-horizontal" method="post" action="{{ url('/admin/profile') }}">
      {{ csrf_field() }}
      @if(Auth::guard('admin')->check())
      <input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
      @else
      <input type="hidden" name="user_id" value="{{ Auth::guard('user')->user()->id }}">
      @endif
      <div class="box-body">
        <div class="form-group">
          <label for="full_name" class="col-sm-2 control-label" >Full Name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Your Full Name" style="text-transform: capitalize">
          </div>
        </div>

        <div class="form-group">
          <label for="icno" class="col-sm-2 control-label">MyKad/Passport No.</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="icno" id="icno" placeholder="Your Mykad/Passport No">
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
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="contact_no" class="col-sm-2 control-label">Mobile No</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Mobile No">
          </div>
        </div>

        <div class="form-group">
          <label for="contact_no2" class="col-sm-2 control-label">Tel No(home)</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" name="contact_no2" id="contact_no2" placeholder="Tel No">
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
</div>

@endsection
