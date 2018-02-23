@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
Agents Store List
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

<?php $page_title = 'Agents Store List'; ?>

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Agent's Store List</h3>
                
            </div>
            <div class="panel-body">
				
				<table class="table datatable table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Agent's Store</th>
							{{-- <th>PV</th> --}}
							{{-- <th>Total</th>
							<th>Status</th>
							<th>Balance</th>--}}
							<th>Action</th> 
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($qualified_agents as $agent)
						<tr>
							<td>{{ $row++ }}</td>
							<td>
								{{ $agent->user->username }}
							</td>
							{{-- <td>
								{{ $agent->user->wallet->pv }}
							</td> --}}
							{{-- <td>
								{{ $qualified_agents->total }}
							</td>
							<td>
								{{ $qualified_agents->status }}
							</td>
							<td>
								{{ $qualified_agents->balance }}
							</td> --}}
							{{-- <td>
								<a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$invoice->id}}">Update</a> |
								<a class="btn btn-primary" href="{{url('invoices/'.$invoice->id)}}">View</a>
							</td> --}}
							<td>
								<a href="{{ url('shop/agent-store/'.$agent->id )}}">Store</a>
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

