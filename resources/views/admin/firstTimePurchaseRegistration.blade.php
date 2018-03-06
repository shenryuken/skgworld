@extends('layouts.joli.app')
<?php $page_title = 'Register New Member'; ?>
@section('content')

<div class="row">
	<div class="col-md-12">

	</div>	
</div>


@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<!-- DataTables -->
<script src="{{ asset('themes/Homer/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- THIS PAGE PLUGINS -->
    
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/dropzone/dropzone.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/fileinput/fileinput.min.js')}}"></script>  
<!-- END THIS PAGE PLUGINS -->  

  
<!-- END SCRIPTS -->     
@stop