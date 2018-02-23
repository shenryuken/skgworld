@extends('layouts.joli.app')
{{-- Page title --}}
<?php $page_title = 'Admins - Assign Role'; ?>
@section('content')

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
@if(Auth::guard('admin')->check())
	    
  	<form method="post" action="{{url('user/assignrank')}}">
		{{ csrf_field() }}
		<input type="hidden" name="user_id" value="{{ $user->id }}">

	  	<div class="panel panel-default">
		    <div class="panel-heading ui-draggable-handle">
		      <h3 class="panel-title"><strong>Update</strong></h3>
		      <ul class="panel-controls">
		        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
		      </ul>
		    </div>
		    <div class="panel-body">
		      <div class="form-group">
		        <label class="col-md-3 col-xs-12 control-label">Rank</label>
		        <div class="col-md-6 col-xs-12">
			        <select name="rank" class="form-control">
						@foreach($ranks as $rank)
						<option value="{{$rank->name}}">{{ $rank->name }}</option>
						@endforeach
					</select>
		        </div>
		      </div>

		    </div>
		    <div class="panel-footer">
		      {{-- <button class="btn btn-default">Clear Form</button> --}}
		      <button class="btn btn-primary pull-right" type="submit">Update</button>
		    </div>
	    </div>
  	</form>
@else
	<h3>You do not have permission for this action.</h3>
@endif   
  
</div>

@endsection