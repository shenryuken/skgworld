
@extends('layouts.homer.app')

{{-- Page title --}}
@section('title')
	Members List
@parent
@stop
@section('header_styles')
<link rel="stylesheet" href="{{ asset('themes/Homer/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" type="text/css" />
@stop
<?php $page_title = 'Members List'; ?>

@section('content')
<div class="row">
    <div class="col-lg-12" style="">
        <div class="hpanel">
            <div class="panel-body">
                <h3>Members List</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @if (count($errors) > 0)
    <div class="col-md-12" style="">
	    <div class="alert alert-danger">
	      <ul>
	        @foreach ($errors->all() as $error)
	        <li>{{ $error }}</li>
	        @endforeach
	      </ul>
	    </div>
	</div>
	@endif
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Members List
            </div>
            <div class="panel-body">
                
	      	<table id="example2" class="table table-bordered table-striped">
		        <thead>
			        <tr>
			          <th>No.</th>
			          <th>Name</th>
			          <th>Username</th>
			          <th>Email</th>
			          <th>Mobile No</th>
			          <th>Rank</th>
			          <th>Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <?php
			        	$row = 1;
			        ?>
			        @foreach($members as $member)
			        <tr>
			          <td>{{ $row++ }}</td>
			          <td>
			            {{ $member->profile->full_name or 'Not Updated'}}
			          <td>
			            {{ $member->username }}
			          </td>
			          <td>
			            {{ $member->email }}
			          </td>
			          <td>
			            {{ $member->mobile_no }}
			          </td>
			          <td>
			          	{{ $member->rank->name }}
			          </td>
			          <td>
							<a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$member->id}}">Edit</a> |  
							<a class="btn btn-primary" data-toggle="modal" href="#modal-assignrank{{$member->id}}">Update Rank</a>
							@if(Auth::guard('admin')->user() !== null && Auth::guard('admin')->user()->hasRole('Administrator'))
							<a class="btn btn-primary" href="{{url('referrals/hierarchy/'.$member->id)}}">View Hierarchy</a>
							@endif
							<?php 
							/*
							<a class="btn btn-primary"  href="{{ url('admin/assignrole/'.$member->id)}}">Assign Role</a> |
							<a class="btn btn-primary"  href="{{ url('admin/revokerole/'.$member->id)}}">Revoke Role</a>
							*/
							?>
			          </td>
			        </tr>
			    	@endforeach()
	        	</tbody>
	      	</table>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<!-- DataTables -->
<script src="{{ asset('themes/Homer/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- DataTables buttons scripts -->
<script src="{{ asset('themes/Homer/vendor/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script>
$(function () {
    // Initialize Example 2
    //$('#example2').dataTable();
    $('#example2').dataTable( {
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        buttons: [
                {extend: 'copy',className: 'btn-sm'},
                {extend: 'csv',title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'print',className: 'btn-sm'}
            ]
        });
    });
</script>
@foreach($members as $member)
<div class="modal fade" id="modal-edit{{$member->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header text-center">
				<h4 class="modal-title">Update User</h4>
				{{-- {{ Form::open(array('route' => array('user.update', $member->id), 'id' => 'basic-wizard', 'class' => 'form-horizontal form-bordered', 'files'=>true, 'method'=>'PUT')) }} --}}

				<form method="post" action="{{ action('UserController@update', $member->id)}}" class="form-horizontal form-bordered">
				{{csrf_field()}}
        		<input name="_method" type="hidden" value="PATCH">
	
				<!-- Group -->
				<div class="form-group">
					<label for="username" class="col-sm-4 control-label" >Username</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="username" name="username" value="{{$member->username}}" style="text-transform: capitalize">
					</div>
				</div>
				<!-- // Group END -->
				<!-- Group -->
				<div class="form-group">
					<label for="email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="email" id="email" value="{{$member->email}}">
					</div>
				</div>
				<!-- // Group END -->
				<!-- Group -->
				<div class="form-group">
					<label for="mobile_no" class="col-sm-4 control-label">Mobile No</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{$member->mobile_no}}" style="text-transform: capitalize">
					</div>
				</div>
				<!-- // Group END -->
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						@if(Auth::guard('admin')->check())
						<button class="btn btn-primary" type="submit">Update</button>
						@else
						<button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
						@endif
					</div>
				</div>
			</form>
		</div>
		
	</div>
</div>
<div class="modal fade" id="modal-assignrank{{$member->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header text-center">
				<h4 class="modal-title">Assign Rank</h4>
				<form method="post" action="{{url('user/assignrank')}}">
					{{ csrf_field() }}
					<input type="hidden" name="user_id" value="{{ $member->id }}">
					<!-- select -->
					<div class="form-group">
						<label class="col-sm-4 control-label">Rank</label>
						<div class="col-sm-6">
							<select name="rank" class="form-control">
								@foreach($ranks as $rank)
								<option value="{{$rank->name}}">{{ $rank->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<!-- // Select -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							@if(Auth::guard('admin')->check())
							<button class="btn btn-primary" type="submit">Update</button>
							<button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
							@else
							<button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
							@endif
						</div>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
@endforeach
@stop
