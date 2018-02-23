@extends('layouts.homer.app')
{{-- Page title --}}
@section('title')
Supplier List
@parent
@stop
@section('header_styles')
<link rel="stylesheet" href="{{ asset('themes/Homer/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" type="text/css" />
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
<?php $page_title = 'Supplier List'; ?>
@section('content')
<div class="row">
    <div class="col-lg-12" style="">
        <div class="hpanel">
            <div class="panel-body">
                <h3>Suppliers List</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="hpanel">
			<div class="panel-heading">
				<div class="panel-tools">
					<a class="showhide"><i class="fa fa-chevron-up"></i></a>
					<a class="closebox"><i class="fa fa-times"></i></a>
				</div>
				Suppliers List
			</div>
			<div class="panel-body">
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>Company Name</th>
							<th>Address</th>
							<th>Tel. No</th>
							<th>Fax No</th>
							<th>Email</th>
							<th>Country</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($suppliers as $supplier)
						<tr>
							<td>{{ $row++ }}</td>
							<td>
								{{ $supplier->company_name }}
							</td>
							<td>
								{{ $supplier->street }}, {{ $supplier->postcode}} {{$supplier->city}}, {{$supplier->state}}.
							</td>
							<td>
								{{ $supplier->telephone_no }}
							</td>
							<td>
								{{ $supplier->fax_no }}
							</td>
							<td>
								{{ $supplier->email }}
							</td>
							<td>
								{{ $supplier->country }}
							</td>
							<td>
								<a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$supplier->id}}">Edit</a> |
								@if(!$supplier->personnels->isEmpty())
								<a class="btn btn-primary" href="{{url('suppliers/'.$supplier->id.'/personnels-list')}}">Contact List</a>
								@else
								<a class="btn btn-primary" href="{{url('suppliers/'.$supplier->id.'/addContact')}}">Add Contact</a>
								@endif
							</td>
							{{-- <!-- Modal -->
							<div id="modal-edit{{$supplier->id}}" class="modal fade" style="display: none;" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<!-- Modal heading -->
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h3 class="modal-title">Update</h3>
										</div>
										<!-- // Modal heading END -->
										<!-- Modal body -->
										<div class="modal-body">
											<div class="innerAll">
												<div class="innerLR">
													<div class="modal-footer">
														{{ Form::open(array('route' => array('suppliers.update', $supplier->id), 'id' => 'basic-wizard', 'class' => 'form-horizontal form-bordered', 'files'=>true, 'method'=>'PUT')) }}
														{{ csrf_field() }}
														
														<!-- Group -->
														<div class="form-group">
															<label for="company_name" class="col-sm-4 control-label" >Company Name</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" id="company_name" name="company_name" value="{{$supplier->company_name}}" style="text-transform: capitalize">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="street" class="col-sm-4 control-label">Street</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="street" id="street" value="{{$supplier->street}}">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="postcode" class="col-sm-4 control-label">Postcode</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="postcode" id="postcode" value="{{$supplier->postcode}}" style="text-transform: capitalize">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="city" class="col-sm-4 control-label">City</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="city" id="city" value="{{$supplier->city}}">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="state" class="col-sm-4 control-label">State</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="state" id="state" value="{{$supplier->state}}">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="country" class="col-sm-4 control-label">Country</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="country" id="country" value="{{$supplier->country}}" style="text-transform: capitalize">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="telephone_no" class="col-sm-4 control-label">Telephone No</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="telephone_no" id="telephone_no" value="{{$supplier->telephone_no}}" style="text-transform: capitalize">
															</div>
														</div>
														<!-- // Group END -->
														<!-- Group -->
														<div class="form-group">
															<label for="fax_no" class="col-sm-4 control-label">Fax No</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="fax_no" id="fax_no" value="{{$supplier->fax_no}}"style="text-transform: capitalize">
															</div>
														</div>
														<!-- // Group END -->
														
														<!-- Group -->
														<div class="form-group">
															<label for="email" class="col-sm-4 control-label">Email</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="email" id="description" value="{{$supplier->email}}">
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
									</div>
									<!-- // Modal body END -->
								</div>
							</div>
						</div> --}}
						<!-- // Modal END -->
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
@stop