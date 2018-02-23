@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

@section('content')
<?php 
    use Carbon\Carbon;
    $page_title = 'Reports: Members'; 
?>

<div class="row">  
    <div class="col-md-2">                        
        <a href="#" class="tile tile-primary">
            {{ $reports['ALL']}}
            <p>All</p>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-info">
            {{ $reports['C']}}
            <p>Customer</p>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-info">
            {{ $reports['LC']}}
            <p>Loyal Cutomer</p>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-info">
            {{ $reports['MO']}}
            <p>Marketing Officer</p>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-info">
            {{ $reports['DO']}}
            <p>District Officer</p>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-info">
            {{ $reports['SDO']}}
            <p>Senior District Officer</p>                            
        </a>                        
    </div>
</div>          
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>{{ Carbon::today()->year }} Monthly Registered Member Activity</h3>
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
                <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
            </div>                                    
        </div>
        <!-- END USERS ACTIVITY BLOCK -->
    </div>
</div>                                      
@php
    // $label = "[";

    // $data = $reports['monthly_register'];

    // //echo count($data);

    // $i = 0;
    // $len = count($data);

    // foreach ($data as $data) {
    //     if($i  == 0)
    //     {
    //         $label .= "'".$data->month .'-'. $data->year ."'".',';
    //         $i++;
    //     }elseif ($i == $len - 1) {
    //         $label .= "'".$data->month .'-'. $data->year."'" .']';
    //     }
    // }

    //  foreach ($products as $product) {
    //         $data = [
    //          'y'       => $product->name,
    //          'Sold'    => Stock::where('product_id', $product->id)->where('status', 'Sold')->count(),
    //          'Stock'   => $product->stocks->count(),
    //          'Returned'=> $product->returnGoods->count()
    //         ];

    //         $stats[] = $data;
    //     }

    // echo $label;

@endphp

@endsection

@section('footer_scripts')
<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/raphael-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/morris.min.js') }}"></script>
<!-- END THIS PAGE PLUGINS-->    
<script type="text/javascript">

    var datasource = <?php echo $reports['monthly_register'];?>
    
     Morris.Bar({
        element: 'dashboard-bar-1',
        data: datasource,
        xkey: 'y',
        ykeys: ['Registered'],
        labels: ['Registered'],
        barColors: ['#33414E'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });
</script>
@stop