@extends('layouts.homer.app')

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
        <div class="hpanel">
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
		<div class="hpanel">
			<div class="panel-heading">
				<div class="panel-tools">
					<a class="showhide"><i class="fa fa-chevron-up"></i></a>
					<a class="closebox"><i class="fa fa-times"></i></a>
				</div>
				Order Items
			</div>
			<div class="panel-body">
				
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No.</th>
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
		<div class="hpanel">
			<div class="panel-heading">
				<div class="panel-tools">
					<a class="showhide"><i class="fa fa-chevron-up"></i></a>
					<a class="closebox"><i class="fa fa-times"></i></a>
				</div>
				Payments History
			</div>
			<div class="panel-body">
				
				<table id="example1" class="table table-bordered table-striped">
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

    $('#example1').dataTable( {
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

