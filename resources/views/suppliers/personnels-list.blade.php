@extends('layouts.homer.app')

{{-- Page title --}}
@section('title')
Personnel List
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}" type="text/css" />
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@stop

<?php $page_title = $company_name; ?>

@section('content')

<div class="row">
	<div class="col-xs-12">

	  <div class="box">
	    <div class="box-header">
	      {{-- <a class="btn btn-primary" href="{{ url('personnel/create') }}">Add Personnel</a> --}}
	      <a class="btn btn-primary" data-toggle="modal" href="#modal-addPersonnel">Add Personnel</a> | 
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
	      <table id="example2" class="table table-bordered table-striped">
	        <thead>
		        <tr>
		          <th>No.</th>
		          <th>Personnel Name</th>
		          <th>Company Name</th>
		          <th>Position</th>
		          <th>Department</th>
		          <th>Mobile No</th>
		          <th>Telephone No (Ext)</th>
		          <th>Email</th>
		          <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
	        <?php
	        	$row = 1;
	        ?>

		        @foreach($personnels as $personnel)
		        <tr>
		          <td>{{ $row++ }}</td>
		          <td>
		            {{ $personnel->name }}
		          </td>
		          <td>
		            {{ $personnel->personnelable->company_name }}
		          </td>
		          <td>
		            {{ $personnel->position }}
		          </td>
		          <td>
		            {{ $personnel->department }}
		          </td>
		          <td>
		            {{ $personnel->mobile_no }}
		          </td>
		          <td>
		            {{ $personnel->phone_no }} Ext:{{$personnel->ext_no}}
		          </td>
		          <td>
		          	{{ $personnel->email }}
		          </td>
		          <td>
						<a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$personnel->id}}">Edit</a> 
		          </td>
		         
		        </tr>
		    	@endforeach()
	    	
	        </tbody>
	      </table>
	    </div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	  @if ($message = Session::get('success'))

			<div class="alert alert-success alert-block">

				<button type="button" class="close" data-dismiss="alert">×</button>

			        <strong>{{ $message }}</strong>

			</div>
			
			<img src="{{ asset( Session::get('file') ) }}">

	   @endif
	</div>
	<!-- /.col -->
	</div>
	<!-- /.row -->
@stop
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
<div class="modal fade" id="modal-addPersonnel" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header text-center">
				<h4 class="modal-title">Add New Personnel</h4>
				<form class="form-horizontal" method="post" action="{{ url('suppliers/addPersonnel') }}">
					{{ csrf_field() }}
					<input type="hidden" name="supplier_id" value="{{$supplier->id}}">
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
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							@if(Auth::guard('admin')->check())
							<button class="btn btn-primary" type="submit">Add Personnel</button>
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
@foreach($personnels as $personnel)
<div class="modal fade" id="modal-edit{{$personnel->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header text-center">
				<h4 class="modal-title">UpdatePersonnel</h4>
				{{ Form::open(array('route' => array('suppliers.personnel.update', $personnel->id), 'id' => 'basic-wizard', 'class' => 'form-horizontal form-bordered', 'files'=>true, 'method'=>'PUT')) }}
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label for="full_name" class="col-sm-2 control-label" >Full Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Contact Name" style="text-transform: capitalize" value="{{ $personnel->name }}">
							</div>
						</div>
						<div class="form-group">
							<label for="department" class="col-sm-2 control-label">Department</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="department" id="department" placeholder="Department" style="text-transform: capitalize" value="{{$personnel->department}}">
							</div>
						</div>
						<div class="form-group">
							<label for="position" class="col-sm-2 control-label">Position</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="position" id="position" placeholder="Position" value="{{ $personnel->position}}">
							</div>
						</div>
						<div class="form-group">
							<label for="mobile_no" class="col-sm-2 control-label">Mobile No</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" style="text-transform: capitalize" value="{{ $personnel->mobile_no}}">
							</div>
						</div>
						<div class="form-group">
							<label for="phone_no" class="col-sm-2 control-label">Telephone No (Office)</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Telephone No (Office)" style="text-transform: capitalize" value="{{ $personnel->phone_no}}">
							</div>
						</div>
						<div class="form-group">
							<label for="ext_no" class="col-sm-2 control-label">Ext. No</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="ext_no" id="ext_no" placeholder="Extention No" style="text-transform: capitalize" value="{{ $personnel->ext_no}}">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="email" id="email" value="{{ $personnel->email }}" >
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							@if(Auth::guard('admin')->check())
							<button class="btn btn-primary" type="submit">Update Personnel</button>
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






