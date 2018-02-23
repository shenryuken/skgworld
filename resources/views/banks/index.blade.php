@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
Banks List
@parent
@stop

<?php $page_title = 'Banks List'; ?>

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Banks List   
			</div>
			<div class="panel-body">
				
				<table id="customer2" class="table datatable">
					<thead>
						<tr>
							<td>No</td>
							<td>Name</td>
							<td>Code</td>
							<td>Status</td>
							<td>Origin Country</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($banks as $bank)
						<tr>
							<td>{{ $row++ }}</td>
							<td>{{ $bank->name }}</td>
							<td>
								{{ $bank->code }}
							</td>
							<td>
								{{ $bank->status }}
							</td>
							<td>{{ $bank->origin_country }}</td>
							<td>
								<a class="btn btn-primary" href="{{url('banks/'.$bank->id.'/edit')}}">Update</a> |
								<a class="btn btn-primary" href="{{url('banks/'.$bank->id)}}">View</a>
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
 <script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js"') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script> 
@stop

