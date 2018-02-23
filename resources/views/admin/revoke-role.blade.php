@extends('layouts.joli.app')
{{-- Page title --}}
<?php $page_title = 'Admins - Revoke Role'; ?>
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
	    
  	@foreach($admin->roles as $role)
	<form method="post" action="{{ url('admin/revokerole')}}">
		{{csrf_field()}}

	  	<div class="panel panel-default">
		    <div class="panel-heading ui-draggable-handle">
		      <h3 class="panel-title"><strong>Update</strong></h3>
		      <ul class="panel-controls">
		        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
		      </ul>
		    </div>
		    <div class="panel-body">
		      <input type="hidden" name="user_id" value="{{ $admin->id }}">
					<div class="form-group">
						
						<label class="col-sm-2 control-label">Role</label>
						<div class="col-sm-10">
							<input type="text" name="role" value="{{ $role->name }}">
							<button type="submit" class="btn btn-info">Revoke</button>
						</div>
					</div>

		    </div>
		    <div class="panel-footer">
		      {{-- <button class="btn btn-default">Clear Form</button> --}}
		      <button class="btn btn-primary pull-right" type="submit">Update</button>
		    </div>
	    </div>
  	</form>
  	@endforeach
@else
	<h3>You do not have permission for this action.</h3>
@endif   
  
</div>

@endsection


<div class="modal fade in" id="modal-revoke-role{{$admin->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header text-center">
				<h4 class="modal-title">Revoke Role</h4>
				{{-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> --}}
			</div>
			<div class="modal-body">
				<p>
				@foreach($admin->roles as $role)
					<form method="post" action="{{ url('admin/revokerole')}}">
					
					{{ csrf_field() }}
					<input type="hidden" name="user_id" value="{{ $admin->id }}">
					<div class="form-group">
						
						<label class="col-sm-2 control-label">Role</label>
						<div class="col-sm-10">
							<input type="text" name="role" value="{{ $role->name }}">
							<button type="submit" class="btn btn-info">Revoke</button>
						</div>
					</div>
					
					</form>
			
				@endforeach
				</p>
				<br>
				

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>