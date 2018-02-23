@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
	Admins List
	@parent
@stop

<?php $page_title = 'Admins List'; ?>
@section('content')
	
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
		<div class="col-md-12">
			<div class="panel panel-default">
				
				<div class="panel-heading">
	                <h3 class="panel-title">Admins List</h3>
	                <div class="btn-group pull-right">
	                    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
	                    <ul class="dropdown-menu">
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/json.png') }}" width="24"/> JSON</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"><img src="{{ asset('themes/Joli/img/icons/json.png') }}" width="24"/> JSON (ignoreColumn)</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'true'});"><img src="{{ asset('themes/Joli/img/icons/json.png')}}" width="24"/> JSON (with Escape)</a></li>
	                        <li class="divider"></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'xml',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/xml.png') }}" width="24"/> XML</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'sql'});"><img src="{{ asset('themes/Joli/img/icons/sql.png') }}" width="24"/> SQL</a></li>
	                        <li class="divider"></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/csv.png') }}" width="24"/> CSV</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'txt',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/txt.png') }}" width="24"/> TXT</a></li>
	                        <li class="divider"></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/xls.png') }}" width="24"/> XLS</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'doc',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/word.png')}}" width="24"/> Word</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'powerpoint',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/ppt.png') }}" width="24"/> PowerPoint</a></li>
	                        <li class="divider"></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/png.png') }}" width="24"/> PNG</a></li>
	                        <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src="{{ asset('themes/Joli/img/icons/pdf.png') }}" width="24"/> PDF</a></li>
	                    </ul>
	                </div>                                    
	                
	            </div>
				<div class="panel-body">
					
					<table id="customers2" class="table datatable">
						<thead>
							<tr>
								<th>No.</th>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Mobile No</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$row = 1;
							?>
							@foreach($admins as $admin)
							<tr>
								<td>{{ $row++ }}</td>
								<td>
									{{ $admin->profile->full_name or 'Not Updated'}}
								</td>
								<td>
									{{ $admin->username }}
								</td>
								<td>
									{{ $admin->email }}
								</td>
								<td>
									{{ $admin->mobile_no }}
								</td>
								<td>
									@foreach($admin->roles as $role)
										{{$role->name}},
						          	@endforeach()
								</td>
								<td>
									<a href="{{ url('admin/'.$admin->id.'/edit')}}" class="btn btn-default btn-sm">Edit</a> |
									<a href="{{ url('admin/assignrole')}}" class="btn btn-default btn-sm">Assign Role</a> |
									<a href="{{ url('admin/revokerole/'.$admin->id)}}" class="btn btn-default btn-sm">Revokes Role</a>
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