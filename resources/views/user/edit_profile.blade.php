@extends('layouts.homer.app')
{{-- Page title --}}
	@section('title')

	Edit Profile
	
	@parent
	@stop

<?php $page_title = 'Edit Profile'; ?>
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
			
			{{ Form::model($profile, array('route' => array('profile.update', $profile->id),'id' => 'validateSubmitForm', 'class' => 'form-horizontal', 'method' => 'PUT')) }}
			{{ csrf_field() }}
			@if( Auth::guard('admin')->check())
			<input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
			@else
			<input type="hidden" name="user_id" value="{{ Auth::guard('user')->user()->id }}">
			@endif
			<div class="box-body">
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
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-info pull-right" v-on:click="click" :disabled="clicked">Update</button>
			</div>
			<!-- /.box-footer -->
		</form>
	</div>
	<!-- /.box -->
</div>

@endsection