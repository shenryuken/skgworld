@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

@section('content')
<?php 
    use Carbon\Carbon;
    $page_title = 'Reports: Bonuses'; 

?>

<div class="row">  
    <div class="col-md-4 col-md-offset-4">                        
        <a href="#" class="tile tile-primary">
            {{ number_format($reports['total_bonus'], 2) }}
            <p>Total Bonus Payout Of Year: {{ Carbon::today()->year }}</p>                            
        </a>                        
    </div>
</div>
<div class="row">
    <div class="col-md-3">                        
        <a href="#" class="tile tile-success">
            {{ number_format($reports['retail_profit'],2) }}
            <p>Retail Profit</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-primary">
            {{ number_format($reports['direct_sponsor'],2) }}
            <p>Direct Sponsor</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-default">
            {{ number_format($reports['personal_rebate'],2) }}
            <p>Personal Rebate</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-danger">
            {{ number_format($reports['do_group_bonus'],2) }}
            <p>Do Group Bonus</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-info">
            {{ number_format($reports['sdo_group_bonus'],2) }}
            <p>SDO Group Bonus</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-warning" style="background-color: grey;">
            {{ number_format($reports['do_cto_pool'],2) }}
            <p>DO CTO POOL</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-info" style="background-color: mediumseagreen;">
            {{ number_format($reports['sdo_cto_pool'],2) }}
            <p>SDO CTO POOL</p>                            
        </a>                        
    </div>
    <div class="col-md-3">                        
        <a href="#" class="tile tile-info" style="background-color: darkslategrey;">
            {{ number_format($reports['sdo_sdo'],2) }}
            <p>SDO TO SDO</p>                            
        </a>                        
    </div>
</div>          
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>{{ Carbon::today()->year }} Monthly Bonus Activity</h3>
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
<script type="text/javascript">

    var datasource = <?php echo $reports['monthly_total_bonus'];?>
    
     Morris.Bar({
        element: 'dashboard-bar-1',
        data: datasource,
        xkey: 'y',
        ykeys: ['Total Bonus'],
        labels: ['Total Bonus'],
        barColors: ['#33414E'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });
</script>
@stop