@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop
@section('content')
<?php $page_title = 'Admin Dashboard'; ?>

{{-- <div class="row">  
    <div class="col-md-12"> 
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <h3 class="panel-title">My Account</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th>Position</th>
                            <th>Date Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile_no }} </td>
                            <td>{{ $user->job_title or 'Admin Clerk'}}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    </tbody>
                </table>                                
            </div>
        </div>
    </div>
</div>  --}}                          
<div class="row">
    <div class="col-md-4">

        <div class="widget widget-primary widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-users"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count">{{ $user_stats['ALL'] }}</div>
                <div class="widget-title">Registred users</div>
                <div class="widget-subtitle">On our website and app</div>
            </div>
            <div class="widget-controls">                                
                <a href="{{ url('reports/members')}}" class="widget-control-right"><span class="fa fa-bars"></span></a>
            </div>                            
        </div>
        <div class="panel-footer contact-footer">
            <div class="row">
                <div class="col-md-2 border-right" style="">
                    <div class="contact-stat"><span>C: </span> <strong>{{ $user_stats['C'] }}</strong></div>
                </div>
                <div class="col-md-2 border-right" style="">
                    <div class="contact-stat"><span>LC: </span> <strong>{{ $user_stats['LC'] }}</strong></div>
                </div>
                <div class="col-md-2" style="">
                    <div class="contact-stat"><span>MO: </span> <strong>{{ $user_stats['MO'] }}</strong></div>
                </div>
                <div class="col-md-2 border-right" style="">
                    <div class="contact-stat"><span>DO: </span> <strong>{{ $user_stats['DO'] }}</strong></div>
                </div>
                <div class="col-md-2" style="">
                    <div class="contact-stat"><span>SDO: </span> <strong>{{ $user_stats['SDO'] }}</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="widget widget-primary widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-tags"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count">MYR {{ number_format($sale_stats['total_sales'],2) }}</div>
                <div class="widget-title">Sales of {{ \Carbon\Carbon::now()->year}}</div>
                <div class="widget-subtitle">Total of PV: {{ number_format($sale_stats['total_pv']) }}</div>
            </div>
            <div class="widget-controls">                                
                <a href="{{ url('reports/sales') }}" class="widget-control-right"><span class="fa fa-bars"></span></a>
            </div>                            
        </div>
        <div class="panel-footer contact-footer">
            <div class="row">
                <div class="col-md-3 border-right" style="">
                    <div class="contact-stat"><span>Today: </span> <strong>{{ number_format($sale_stats['today'],2) }}</strong></div>
                </div>
                <div class="col-md-3 border-right" style="">
                    <div class="contact-stat"><span>This Week: </span> <strong>{{ number_format($sale_stats['this_week'],2) }}</strong></div>
                </div>
                <div class="col-md-3" style="">
                    <div class="contact-stat"><span>This Month: </span>
                    @if($sale_stats['this_month'])
                        <strong>{{ number_format($sale_stats['this_month']->total_sale,2) }}</strong></div>
                    @else
                        0</strong></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="widget widget-primary widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-dollar"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count">MYR {{ number_format($bonus['total_bonus'],2) }}</div>
                <div class="widget-title">Bonus Payout of {{ \Carbon\Carbon::now()->year}}</div>
                <div class="widget-subtitle">Bonus Payout of {{ \Carbon\Carbon::now()->year}}</div>
            </div>
            <div class="widget-controls">                                
                <a href="{{ url('reports/bonuses')}}" class="widget-control-right"><span class="fa fa-bars"></span></a>
            </div>                            
        </div>
        <div class="panel-footer contact-footer">
            <div class="row">
                <div class="col-md-4 border-right" style="">
                    <div class="contact-stat"><span>Last Month: </span> <strong>{{ number_format($bonus['last_month_bonus'],2) }}</strong></div>
                </div>
                {{-- <div class="col-md-3 border-right" style="">
                    <div class="contact-stat"><span>This Week: </span> <strong>{{ number_format($sale_stats['this_week'],2) }}</strong></div>
                </div>
                <div class="col-md-3" style="">
                    <div class="contact-stat"><span>This Month: </span> <strong>{{ number_format($sale_stats['this_month'],2) }}</strong></div>
                </div> --}}
            </div>
        </div>
    </div>
</div>  
<br>    
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Sales & Stock Activity</h3>
                    <span>
                        <strong>
                        @foreach($sales_stock_activity1 as $product)
                            @if($loop->last)
                                {{ $product['y'] }}
                            @else
                                {{ $product['y'] }}, 
                            @endif
                        @endforeach
                        </strong>
                    </span>
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
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Sales & Stock Activity</h3>
                    <span>
                        <strong>
                        @foreach($sales_stock_activity2 as $product)
                            @if($loop->last)
                                {{ $product['y'] }}
                            @else
                                {{ $product['y'] }}, 
                            @endif
                        @endforeach
                        </strong>
                    </span>
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
                <div class="chart-holder" id="dashboard-bar-2" style="height: 200px;"></div>
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

    var datasource1 = <?php echo json_encode($sales_stock_activity1);?>
   
    Morris.Bar({
        element: 'dashboard-bar-1',
        data: datasource1,
        xkey: 'y',
        ykeys: ['Sold', 'Stock', 'Returned'],
        labels: ['Sold', 'Stock', 'Returned'],
        barColors: ['#33414E', '#1caf9a', '#987cde'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });

</script>
<script type="text/javascript">

    var datasource2 = <?php echo json_encode($sales_stock_activity2);?>

    Morris.Bar({
        element: 'dashboard-bar-2',
        data: datasource2,
        xkey: 'y',
        ykeys: ['Sold', 'Stock', 'Returned'],
        labels: ['Sold', 'Stock', 'Returned'],
        barColors: ['#33414E', '#1caf9a', '#987cde'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });

</script>
@stop