@extends('layouts.homer.app')

{{-- Page title --}}
@section('title')
Hierachy Chart
@parent
@stop

@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('/OrgChart/jquery.orgchart.css')}}">
<style type="text/css">
	.orgchart .sdo .title {
	  background-color: #006699;
	}
	.orgchart .sdo .content {
	  border-color: #006699;
	}
	.orgchart .do .title {
	  background-color: #009933;
	}
	.orgchart .do .content {
	  border-color: #009933;
	}
	.orgchart .mo .title {
	  background-color: #993366;
	}
	.orgchart .mo .content {
	  border-color: #993366;
	}

	.orgchart .lc .title {
	  background-color: maroon;
	}
	.orgchart .lc .content {
	  border-color: #993366;
	}
</style>
@stop

<?php $page_title = 'Hierarchy'; ?>

@section('content')
	<?php

	  	$datasource = json_encode($tree);
	  	$output = substr($datasource, 1, -1);
	  	//$data = json_encode(array_map('strval', $tree));
	  	 
		/* echo '<pre>';
			print_r($tree);

		 echo '</pre><br/>';*/

		/* echo '<pre>';
			print_r($output);

		 echo '</pre><br/>';*/

	   //var_dump($tree);
	?>
<div class="row">
    <div class="col-lg-12" style="">
        <div class="hpanel">
            <div class="panel-body">
                <h3>My Organization Chart</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default" >
			<div class="panel-heading">My Organization Chart</div>
			
			<div id="chart-container" style="overflow: auto;"></div>
		</div>
	</div>
</div> 

  
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<!-- OrgChart -->
<script type="text/javascript" src="{{ asset('/OrgChart/jquery.orgchart.js')}}"></script>

<!-- Export To Pdf -->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script-->
<script src="{{ asset('themes/Homer/vendor/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- page script -->
<script>
var datasource = <?php echo $output;?>
 
$('#chart-container').orgchart({
  'data' : datasource,
  'depth': 10,
  'nodeContent': 'title',
  'exportButton': true,
  'exportFilename': 'MyOrgChart',
  'exportFileextension': 'pdf',
  'pan': true,
  'zoom': true
});
</script>
@stop