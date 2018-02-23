@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

@section('content')
<?php 
    use Carbon\Carbon;
    $page_title = 'Reports: Sales of Products'; 

?>

<div class="row">  
	<div class="col-md-2">                        
        <a href="#" class="tile tile-primary">
            <strong>{{ Carbon::today()->year }}</strong>              
        </a>                        
    </div>
    <div class="col-md-4">                        
        <a href="#" class="tile tile-primary">
            <strong>MYR {{ number_format($reports['total_amount_this_year'],2) }}</strong>
            <p>Total Selling Price</p>                            
        </a>                        
    </div>
    <div class="col-md-4">                        
        <a href="#" class="tile tile-warning">
            <strong>{{ number_format($reports['total_quantity_this_year']) }}</strong>
            <p>Total Selling Quantity</p>                            
        </a>                        
    </div>
</div>
<div class="row">  
	<div class="col-md-2">                        
        <a href="#" class="tile tile-primary">
            <strong>{{ Carbon::today()->year - 1 }}</strong>              
        </a>                        
    </div>
    <div class="col-md-4">                        
        <a href="#" class="tile tile-primary">
            <strong>MYR {{ number_format($reports['total_amount_last_year'],2) }}</strong>
            <p>Total Selling Price</p>                            
        </a>                        
    </div>
    <div class="col-md-4">                        
        <a href="#" class="tile tile-warning">
            <strong>{{ number_format($reports['total_quantity_last_year']) }}</strong>
            <p>Total Selling Quantity</p>                            
        </a>                        
    </div>
</div>
        
<div class="row">
   <div class="col-md-12">
        
        <!-- START DATATABLE EXPORT -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Monthly Sales For {{ Carbon::today()->year}}</h3>
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
                      <th>Month</th>
                      <th>Total Amount (MYR)</th>
                      <th>Total Quantity</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $row = 1;
                    ?>
                    @foreach($reports['this_year'] as $sale)
                    <tr>
                      <td>{{ $row++ }}</td>
                      <td>
                        {{ date("F", mktime(0, 0, 0, $sale->month, 1)) }}
                      <td>
                        {{ number_format($sale->amount,2) }}
                      </td>
                      <td>
                        {{ number_format($sale->quantity) }}
                      </td>
                      <td>
                      	<a href="{{ url('reports/sales/bymonth/'.$sale->month .'/'.$sale->year)}}">Show Details</a>
                      </td>
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
        
        <!-- START DATATABLE EXPORT -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Monthly Sales For {{ Carbon::today()->year - 1}}</h3>
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
                     
                      <th>Month</th>
                      <th>Total Amount (MYR)</th>
                      <th>Total Quantity</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $row = 1;
                    ?>
                    @foreach($reports['last_year'] as $sale)
                    <tr>
                      <td>{{ $row++ }}</td>
   
                      <td>
                        {{ date("F", mktime(0, 0, 0, $sale->month, 1)) }}
                      <td>
                        {{ number_format($sale->amount,2) }}
                      </td>
                      <td>
                        {{ number_format($sale->quantity) }}
                      </td>
                      <td>
                        <a href="{{ url('reports/sales/bymonth/'.$sale->month .'/'.$sale->year)}}">Show Details</a>
                      </td>
                    </tr>
                    @endforeach()
                </tbody>
                </table>                                    
                
            </div>
        </div>
        <!-- END DATATABLE EXPORT -->       
        @php
        	dump($reports['last_year']->toArray());
        @endphp                     
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

@stop