@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

@section('content')
<?php 
    use Carbon\Carbon;
    $page_title = 'Reports: Sales of '.date("F", mktime(0, 0, 0, $month, 1)) .' '.$year ; 

?>
<div class="row">  
    <div class="col-md-4">                        
        <a href="#" class="tile tile-primary">
            MYR {{ $reports->sum('amount') }}
            <p>Total Selling Price</p>                            
        </a>                        
    </div>
    <div class="col-md-4">                        
        <a href="#" class="tile tile-warning">
            {{ $reports->sum('quantity') }}
            <p>Total Selling Quantity</p>                            
        </a>                        
    </div>
</div>
 
<div class="row">
   <div class="col-md-12">
        
        <!-- START DATATABLE EXPORT -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Sales For {{ date("F", mktime(0, 0, 0, $month, 1))}} {{ $year}}</h3>
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
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Amount</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $row = 1;
                    ?>
                    @foreach($reports as $report)
                    <tr>
                      <td>{{ $row++ }}</td>
                      <td>
                        {{ $report->product->name }}
                      </td>
                      <td>
                        {{ $report->quantity }}
                      </td>
                      <td>
                        {{ $report->amount }}
                      </td>
                      <td></td>
                    </tr>
                    @endforeach()
                </tbody>
                </table>                                    
                
            </div>
        </div>
        <!-- END DATATABLE EXPORT -->                            
    </div>
</div>      
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Sales Comparison: {{ date("F", mktime(0, 0, 0, $month, 1))}} {{ $year}} And {{ $year -1}}</h3>
                    {{-- <span>Sales, Stock And Returned</span> --}}
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>                                    
            </div>                                
            <div class="panel-body padding-0">
                <div class="chart-holder" id="dashboard-bar-1" style="height: 300px;"></div>
            </div>                                    
        </div>
        <!-- END USERS ACTIVITY BLOCK -->
    </div>
</div>     


@endsection

@section('footer_scripts')
<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/raphael-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/morris.min.js') }}"></script>
<!-- END THIS PAGE PLUGINS-->    
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js"') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script>    

<script type="text/javascript">

    var datasource1 = <?php echo json_encode($graph_reports);?>;
    var year        = <?php echo Carbon::today()->year; ?>;
    var year2       = (year -1);
    Morris.Bar({
        element: 'dashboard-bar-1',
        data: datasource1,
        xkey: 'y',
        ykeys: [year, year2],
        labels: [year, year2],
        barColors: ['#33414E', '#1caf9a', '#987cde'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });

</script>

@stop