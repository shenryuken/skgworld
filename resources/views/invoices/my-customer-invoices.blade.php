@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
My Customer Invoices List
@parent
@stop

<?php $page_title = 'My Customer Invoices List'; ?>

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Invoices List
			</div>
			<div class="panel-body">
				
				<table class="table datatable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Date</th>
							@if(Auth::guard('admin')->check())
							<th>Username</th>
							@endif
							<th>Delivery Cost</th>
							<th>Total</th>
							<th>Status</th>
							<th>Balance</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($invoices as $invoice)
						<tr>
							<td>{{ $row++ }}</td>
							<td>{{ $invoice->created_at->format('d-m-Y') }}</td>
							@if(Auth::guard('admin')->check())
							<td>
								{{ $invoice->user->username }}
							</td>
							@endif
							<td>
								{{ $invoice->delivery_cost }}
							</td>
							<td>
								{{ $invoice->total }}
							</td>
							<td>
								{{ $invoice->status }}
							</td>
							<td>
								{{ $invoice->balance }}
							</td>
							<td>
								<a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$invoice->id}}">Update</a> |
								<a class="btn btn-primary" href="{{url('invoices/my-customer/'.$invoice->id)}}">View</a>
							</td>
						</tr>
						@endforeach()
						
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
		@if (Session::get('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
		@endif
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<!-- START SCRIPTS -->
   
    <!-- START THIS PAGE PLUGINS-->        
    <script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script>        
    <!-- END THIS PAGE PLUGINS-->  
    
    <!-- END SCRIPTS --> 
     
@stop
