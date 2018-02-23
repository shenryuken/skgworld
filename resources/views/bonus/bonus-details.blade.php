@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
Bonus Details
<style type="text/css">
	body
	{
	 margin:0 auto;
	 padding:0px;
	 text-align:center;
	 width:100%;
	 font-family: "Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
	}
	#wrapper
	{
	 margin:0 auto;
	 padding:0px;
	 text-align:center;
	 width:995px;
	}
	#wrapper h1
	{
	 margin-top:50px;
	 font-size:45px;
	 color:#585858;
	}
	#wrapper h1 p
	{
	 font-size:20px;
	}
	#table_detail
	{
	 width:500px;
	 text-align:left;
	 border-collapse: collapse;
	 color:#2E2E2E;
	 border:#A4A4A4;
	}
	#table_detail tr:hover
	{
	 background-color:#F2F2F2;
	}
	#table_detail .hidden_row
	{
	 display:none;
	}
</style>
@parent
@stop

<?php $page_title = 'Bonus Details'; ?>

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Personal Summary Bonus
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
				
				<table id="customer2 table_detail" class="table datatable">
					<thead>
						<tr>
							<th>Retail Profit</th>
							<th>Personal Rebate</th>
							<th>Direct Sponsor</th>
							<th>DO Group Bonus</th>
							<th>SDO Group Bonus</th>
							<th>DO Pool</th>
							<th>SDO Pool</th>
							<th>SDO SDO</th>
							<th>Total Bonus</th>			
						</tr>
					</thead>
					<tbody>
					
						<tr onclick="show_hide_row('hidden_row1');">			
							<td>{{ $userBonus->retail_profit }}</td>
							<td>{{ $userBonus->personal_rebate }}</td>
							<td>{{ $userBonus->direct_sponsor }}</td>
							<td>{{ $userBonus->do_group_bonus }}</td>
							<td>{{ $userBonus->sdo_group_bonus }}</td>
							<td>{{ $userBonus->do_cto_pool }}</td>
							<td>{{ $userBonus->sdo_cto_pool }}</td>
							<td>{{ $userBonus->sdo_sdo }}</td>
							<td>{{ $userBonus->total_bonus }}</td>
						</tr>
						<tr id="hidden_row1" class="hidden_row">
							<td>
								<ul>
									<li>Personal Retail Profit:{{ $retail_profit }}</li> 
								    <li>Override              :{{ $override_retail_profit }}</li>
								</ul>
							</td>
							<td>
								<ul>
									<li>Personal Rebate:{{ $personal_rebate}}</li>
									<li>Override       :{{ $override_personal_rebate}}</li>
								</ul>
							</td>
							<td>
								<ul>
									<li>Direct Sponsor:{{ $direct_sponsor }}</li>
									<li>Indirect      :{{ $indirect_sponsor }}</li>
								</ul>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
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
				Personal Retail Price, Override Retail Price
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
				
				<table id="customer2" class="table datatable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Username</th>
							<th>Rank</th>
							<th>Override Retail Profit</th>
							<th>Override Personal Rebate</th>
							<th>Direct Sponsor</th>
							<th>Indirect Sponsor</th>
							<th>Group Bonus</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$row = 1;
						?>
						@foreach($downlines as $downline)
						<tr>
							<td>{{ $row++ }}</td>				
							<td>{{ $downline['username'] }}</td>
							<td>{{ $downline['rank_id'] }}</td>
							<td>{{ $downline['override_retail_profit'] }}</td>
							<td>{{ $downline['override_personal_rebate'] }}</td>
							<td>{{ $downline['direct_sponsor'] }}</td>
							<td>{{ $downline['indirect_sponsor'] }}</td>
							<td>{{ $downline['group_bonus']}}</td>
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

	<script type="text/javascript">
		function show_hide_row(row)
		{
		 $("#"+row).toggle();
		}
	</script>
@stop

