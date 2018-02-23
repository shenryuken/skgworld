@extends('layouts.joli.app')
{{-- Page title --}}
	@section('title')

	Edit Profile
	
	@parent
	@stop

<?php $page_title = 'Edit Profile'; ?>
@section('content')
<div class="row">
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
	<div class="col-md-12">	
		<form class="form-horizontal" method="post" action="{{ route('profile.update', $profile->id) }}">
			<div class="panel panel-default">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT">
	            <div class="panel-heading">
	                <h3 class="panel-title"><strong>Profile</strong></h3>
	                <ul class="panel-controls">
	                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
	                </ul>
	            </div>
	            <div class="panel-body">  
					<div class="form-group">
						<label for="full_name" class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="full_name" name="full_name" value="{{ $profile->full_name}}" style="text-transform: capitalize">
						</div>
					</div>

					<div class="form-group">
						<label for="icno" class="col-sm-2 control-label">MyKad/Passport No.</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="icno" id="icno" value="{{ $profile->icno }}">
						</div>
					</div>

					<div class="form-group">
						<label for="street" class="col-sm-2 control-label">Street</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="street" id="street" value="{{ $profile->street}}" style="text-transform: capitalize">
						</div>
					</div>

					<div class="form-group">
						<label for="postcode" class="col-sm-2 control-label">Postcode</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="postcode" id="postcode" value="{{ $profile->postcode }}" style="text-transform: capitalize">
						</div>
					</div>

					<div class="form-group">
						<label for="city" class="col-sm-2 control-label">City</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="city" id="city" value="{{ $profile->city }}" style="text-transform: capitalize">
						</div>
					</div>

					<div class="form-group">
						<label for="state" class="col-sm-2 control-label">State</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="state" id="state" value="{{ $profile->state }}" style="text-transform: capitalize">
						</div>
					</div>
					<!-- select -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10">
							<select name="country" class="form-control">
								<option value="Malaysia" {{ $profile->country == 'Malaysia' ? 'selected' :'' }} >Malaysia</option>
								<option value="Singapore" {{ $profile->country == 'Singapore' ? 'selected' :'' }} >Singapore</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="contact_no" class="col-sm-2 control-label">Mobile No</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="contact_no" id="contact_no" value="{{ $profile->contact_no }}">
						</div>
					</div>

					<div class="form-group">
						<label for="contact_no2" class="col-sm-2 control-label">Tel No(home)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="contact_no2" id="contact_no2" value="{{ $profile->contact_no2 }}">
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
				<!-- /.box-body -->
				<div class="panel-footer">
					<button type="submit" class="btn btn-info pull-right" v-on:click="click" :disabled="clicked">Update</button>
				</div>
				<!-- /.box-footer -->
			</div>
		</form>
	</div>
	<!-- /.box -->
</div>

@endsection