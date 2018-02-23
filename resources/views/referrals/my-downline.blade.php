@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
My Downline
@parent
@stop
<?php $page_title = 'My Downline'; ?>
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                My Downline (Direct Sponsor)
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Rank</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $row = 1; ?>
                    @foreach($descendants as $descendant)
                        <tr>
                            <td>{{ $row++ }}</td>
                            <td>{{ $descendant->user->username }}</td>
                            <td>{{ $descendant->user->profile->full_name or 'Not Updated' }}</td>
                            <td>{{ $descendant->user->email }}</td>
                            <td>{{ $descendant->user->rank->name }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{url('referrals/hierarchy/'.$descendant->user_id)}}">View Hierarchy</a>
                                @if(Auth::guard('admin')->user() !== null && Auth::guard('admin')->user()->hasRole('Administrator'))
                                <a class="btn btn-primary" data-toggle="modal" href="#modal-edit{{$descendant->user_id}}">Edit</a> |  
                                <a class="btn btn-primary" data-toggle="modal" href="#modal-assignrank{{$descendant->user_id}}">Update Rank</a>
                                @endif
                                <?php 
                                /*
                                <a class="btn btn-primary"  href="{{ url('admin/assignrole/'.$member->id)}}">Assign Role</a> |
                                <a class="btn btn-primary"  href="{{ url('admin/revokerole/'.$member->id)}}">Revoke Role</a>
                                */
                                ?>
                            </td>  
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<!-- START SCRIPTS -->
   
    <!-- START THIS PAGE PLUGINS-->        
    <script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script>        
    <!-- END THIS PAGE PLUGINS-->  
    
    <!-- END SCRIPTS --> 
     
@stop