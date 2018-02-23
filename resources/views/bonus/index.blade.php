@extends('layouts.homer.app')


{{-- Page title --}}
@section('title')
Payments List
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('themes/Homer/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" type="text/css" />

@stop

<?php $page_title = 'Bonus Calculation'; ?>

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box">
	    <div class="box-header">
	      Bonus Calculation
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
        <p>Add the classes <code>.btn.btn-app</code> to an <code>&lt;a&gt;</code> tag to achieve the following:</p>
        <!--a class="btn-flat" href="{{ url('bonus/count_do_group_bonus') }}">
          <i class="fa fa-edit"></i> Count Do Group Bonus
        </a--> 
        <a class="btn-flat" href="{{ url('bonus/calculate-end-month-bonus') }}">
          <i class="fa fa-edit"></i> Count Do Group Bonus
        </a>     
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
