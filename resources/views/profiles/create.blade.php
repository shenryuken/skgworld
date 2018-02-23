@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Create Profile
    @parent
@stop
<?php $page_title = 'Profile'; ?>
@section('content')

<div class="row">
    <div class="col-md-12">
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

	    <form class="form-horizontal" method="post" action="{{ url('/profile') }}">
		    <div class="panel panel-default">
		      {{ csrf_field() }}
		      @if(Auth::guard('admin')->check())
		      <input type="hidden" name="profileable_id" value="{{ Auth::guard('admin')->user()->id }}">
		      <input type="hidden" name="profileable_type" value="App\Admin">
		      @else
		      <input type="hidden" name="profileable_id" value="{{ Auth::guard('web')->user()->id }}">
		      <input type="hidden" name="profileable_type" value="App\User">
		      @endif
	            <div class="panel-heading">
	                <h3 class="panel-title"><strong>Profile</strong></h3>
	                <ul class="panel-controls">
	                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
	                </ul>
	            </div>
	      
	            <div class="panel-body">   
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

					<div class="form-group">
						<label class="col-sm-2 control-label">Security Code</label>
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
		          <button class="btn btn-primary pull-right">Submit</button>
		        </div>
		    </div>
	    </form>
	</div>
  <!-- /.box -->
</div>


@endsection
