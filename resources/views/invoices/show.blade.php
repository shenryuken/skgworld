@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
Invoices List
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('themes/Homer/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" type="text/css" />
@stop

<?php $page_title = 'Invoices List'; ?>

@section('content')
<div class="row">
    <div class="col-lg-12" style="">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3><strong>Invoice No: {{ $invoice->invoice_no }}</h3></strong>
                <p>
                	<strong>Date : {{ $invoice->created_at->format('d-m-Y') }}</strong>
                </p>
                <p>
                	<strong>Total Amount : MYR {{ $invoice->total }}</strong><small>  *Inclusive 6% GST</small>
                </p>
				<p>
                	<strong>Balance to be paid : MYR {{ $invoice->balance }}</strong>
                </p>
                <p>
                	<strong>Payment Status : {{ $invoice->status }}</strong>
                </p>
                <p>
                	<strong>Delivery Status : @if($shipment != null){{ $shipment->status }} @else Pending @endif</strong>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Order Items
			</div>
			<div class="panel-body">
				
				<table id="customer2" class="table table-bordered datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>Product Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($order_items as $item)
						<tr>
							<td>{{ $row++ }}</td>
							<td>
								{{ $item->product->name}}
							</td>
							<td>
								{{ $item->qty }}
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
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Payments History
			</div>
			<div class="panel-body">
				
				<table class="table datatable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Date</th>
							<th>Cash</th>
							<th>Voucher</th>
							<th>Ewallet</th>
							<th>Credit/Debit</th>
							<th>Online</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($payments as $payment)
						<tr>
							<td>{{ $row++ }}</td>
							<td>
								{{ $payment->created_at->format('d-m-Y')}}
							</td>
							<td>
								{{ $payment->cash }}
							</td>
							<td>
								{{ $payment->voucher }}
							</td>
							<td>
								{{ $payment->ewallet }}
							</td>
							<td>
								{{ $payment->credit_debit_card }}
							</td>
							<td>
								{{ $payment->online }}
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

