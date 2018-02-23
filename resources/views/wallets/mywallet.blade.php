@extends('layouts.homer.app')
{{-- Page title --}}
@section('title')
My Wallet
@parent
@stop
<?php $page_title = 'My Wallet'; ?>
@section('content')
<div class="row">
    <div class="col-lg-12" style="">
        <div class="hpanel">
            <div class="panel-body">
                <h3>My Wallet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3" style="">
        <div class="hpanel hbggreen">
            <div class="panel-body">
                <div class="text-center">
                    <h3>Current PV</h3>
                    <p class="text-big font-light">
                        {{ $wallet->current_pv or 0}}
                    </p>
                    <small>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="">
        <div class="hpanel hbgblue">
            <div class="panel-body">
                <div class="text-center">
                    <h3>Available PV</h3>
                    <p class="text-big font-light">
                        {{ $wallet->pv or 0}}
                    </p>
                    <small>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="">
        <div class="hpanel hbgyellow">
            <div class="panel-body">
                <div class="text-center">
                    <h3>DO GPV</h3>
                    <p class="text-big font-light">
                        {{ $wallet->do_pv or 0}}{{-- 750 --}}
                    </p>
                    <small>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="">
        <div class="hpanel hbgred">
            <div class="panel-body">
                <div class="text-center">
                    <h3>SDO GPV</h3>
                    <p class="text-big font-light">
                        {{ $wallet->do_pv or 0}}{{-- 43 --}}
                    </p>
                    <small>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Bonus Summary This Month 
            </div>
            <div class="panel-body">
                <table id="example2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bonus</th>
                            <th>Qualify</th>
                            <th>Total Bonus</th>
                            <th>Bonus Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Retail Profit</td>
                            <td>{{$qualified_bonus['retail_profit']}}</td>
                            <td>{{ number_format($user_bonus->retail_profit, 2)}}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Personal Rebate</td>
                            <td>{{$qualified_bonus['personal_rebate']}}</td>
                            <td>{{ number_format($user_bonus->personal_rebate, 2)}}</td>
                            <td>MYR - Evoucher</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Direct Sponsor</td>
                            <td>{{$qualified_bonus['direct_sponsor']}}</td>
                            <td>{{ number_format($user_bonus->direct_sponsor, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>3 Generations Group Bonus</td>
                            <td>{{$qualified_bonus['do_group_bonus']}}</td>
                            <td>{{ number_format($user_bonus->do_group_bonus, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>DO CTO Pool</td>
                            <td>{{$qualified_bonus['do_cto']}}</td>
                            <td>{{ number_format($user_bonus->do_cto_pool, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>SDO CTO Pool</td>
                            <td>{{$qualified_bonus['sdo_cto']}}</td>
                            <td>{{ number_format($user_bonus->sdo_cto_pool, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>SDO Group Bonus</td>
                            <td>{{$qualified_bonus['sdo']}}</td>
                            <td>{{ number_format($user_bonus->sdo_group_bonus, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>SDO To SDO Bonus</td>
                            <td>{{$qualified_bonus['sdo_to_sdo']}}</td>
                            <td>{{ number_format($user_bonus->sdo_sdo, 2) }}</td>
                            <td>MYR</td>
                            <td><a href="">View Details</a></td>  
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
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