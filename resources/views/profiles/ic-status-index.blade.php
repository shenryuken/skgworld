@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
    MyKad\Passport Status Index
    @parent
@stop
@section('content')
<?php $page_title = 'MyKad\Passport Status Index'; ?>

               
<div class="row">
    <div class="col-md-2">                        
        <a href="#" class="tile tile-primary">
            <strong>{{ $count_user }}
            <p>Total Users</p></strong>                         
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-success">
            <strong>{{ $mykad_status['approved'] }}
            <p>Total Approved</p></strong>                             
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-primary" style="background-color: darkslategray">
            <strong>{{ $mykad_status['waiting_approval'] }}
            <p>Total Waiting Approval</p></strong>                             
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-warning">
            <strong>{{ $mykad_status['pending'] }}
            <p>Total Pending</p> </strong>                            
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-danger">
            <strong>{{ $mykad_status['not_valid'] }}
            <p>Total Not Valid</p></strong>                             
        </a>                        
    </div>
    <div class="col-md-2">                        
        <a href="#" class="tile tile-default">
            <strong>{{ $mykad_status['not_update'] }}
            <p>Total Not Update</p></strong>                             
        </a>                        
    </div>
</div>  
<br>    
<div class="row">
    <div class="col-md-12">
    @if ($message = Session::get('fail'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif  
        <div class="panel panel-default">
                
                <div class="panel-heading">
                    <h3 class="panel-title">MyKad\Passport Status List</h3>
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
                                <th>Username</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $row = 1;
                            ?>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $row++ }}</td>
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td>
                                    {{ $user->profile->status_ic or 'Not Update'}}
                                </td>
                                <td>
                                @if(!is_null($user->profile))
                                    <a href="{{ url('profile/show-ic/'.$user->profile->id)}}">View</a>
                                @else
                                    No Profile Found
                                @endif
                                </td>
                            </tr>
                            @endforeach()
                            
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>           
                            

@endsection
@section('footer_scripts')
<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js"') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script>    
<!-- END THIS PAGE PLUGINS-->    

@stop