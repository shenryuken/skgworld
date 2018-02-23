@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop

@section('content')
<?php 
    use Carbon\Carbon;
    $page_title = 'Reports: Stocks'; 

?>

<div class="row">  
    <div class="col-md-4 col-md-offset-4">                        
        <a href="#" class="tile tile-primary">
            {{ count($reports1) + count($reports2) }}
            <p>Total Poducts Of Year: {{ Carbon::today()->year }}</p>                            
        </a>                        
    </div>
</div>
        
<div class="row">
    <div class="col-md-12">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>{{ Carbon::today()->year }} Products Stock Activity</h3>
                    <span>
                    	<strong>
                    		@foreach($reports1 as $product)
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
                    <h3>{{ Carbon::today()->year }} Products Stock Activity</h3>
                    <span>
                    	<strong>
                    		@foreach($reports2 as $product)
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
{{-- {{ dd(json_encode($reports))}}    --}}                         
@endsection

@section('footer_scripts')
<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/raphael-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/morris/morris.min.js') }}"></script>
<!-- END THIS PAGE PLUGINS-->    
<script type="text/javascript">

    var datasource = <?php echo json_encode($reports1);?>
    
     Morris.Bar({
        element: 'dashboard-bar-1',
        data: datasource,
        xkey: 'y',
        ykeys: ['Stocks'],
        labels: ['Stocks'],
        barColors: ['#33414E'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });
</script>
<script type="text/javascript">

    var datasource2 = <?php echo json_encode($reports2);?>
    
     Morris.Bar({
        element: 'dashboard-bar-2',
        data: datasource2,
        xkey: 'y',
        ykeys: ['Stocks'],
        labels: ['Stocks'],
        barColors: ['#33414E'],
        gridTextSize: '12px',
        hideHover: true,
        resize: true,
        gridLineColor: '#E5E5E5'
    });
</script>
@stop