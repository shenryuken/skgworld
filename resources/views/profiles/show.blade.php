@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    My Profile
    @parent
@stop
<?php $page_title = 'My Profile'; ?>
@section('content')

@if($guard == 'admin' && Auth::guard('admin')->user()->profile !== null)

<div class="row">
    {{-- <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
        <A href="edit.html" >Edit Profile</A>
        <A href="edit.html" >Logout</A>
        <br>
        <p class=" text-info">May 05,2014,03:00 pm </p>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
        
        
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $profile->profileable->username }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"> 
                        <img alt="User Pic" src="{{ asset('themes/Joli/assets/images/users/avatar.jpg') }}" class="img-circle img-responsive"> 
                    </div>
                    
                    <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                        <dl>
                            <dt>DEPARTMENT:</dt>
                            <dd>Administrator</dd>
                            <dt>HIRE DATE</dt>
                            <dd>11/12/2013</dd>
                            <dt>DATE OF BIRTH</dt>
                            <dd>11/12/2013</dd>
                            <dt>GENDER</dt>
                            <dd>Male</dd>
                        </dl>
                    </div>-->
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information" >
                            <tbody>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>
                                        <dd>{{ $profile->street }},</dd>
                                        <dd>{{ $profile->postcode }} , {{ $profile->city }},</dd>
                                        <dd>{{ $profile->state }},</dd>
                                        <dd>{{ $profile->country }},</dd>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Joined date</strong></td>
                                    <td>{{ $profile->profileable->created_at }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td><a href="mailto:{{ $profile->profileable->email }}">{{ $profile->profileable->email }}</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Phone Number</strong></td>
                                    <td>
                                        <dd>{{ $profile->contact_no }}</dd>
                                        <dd>{{ $profile->contact_no2 }}</dd>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Roles</strong></td>
                                    <td>
                                        <dd>
                                        @foreach($profile->profileable->roles as $role) 
                                            {{ $role->name }}
                                        @endforeach
                                        </dd>
                                    </td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                <span class="pull-right">
                    <a href="{{ url('/profile/'.$profile->id .'/edit')}}" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                </span>
            </div> 
        </div>
    </div>
</div>

@elseif($guard == 'web' && Auth::guard('web')->user()->profile !== null)
<div class="row">
    {{-- <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
        <A href="edit.html" >Edit Profile</A>
        <A href="edit.html" >Logout</A>
        <br>
        <p class=" text-info">May 05,2014,03:00 pm </p>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
        
        
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $profile->profileable->username }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="{{ asset('themes/Joli/assets/images/users/avatar.jpg') }}" class="img-circle img-responsive"> 
                    </div>
                    
                    <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                        <dl>
                            <dt>DEPARTMENT:</dt>
                            <dd>Administrator</dd>
                            <dt>HIRE DATE</dt>
                            <dd>11/12/2013</dd>
                            <dt>DATE OF BIRTH</dt>
                            <dd>11/12/2013</dd>
                            <dt>GENDER</dt>
                            <dd>Male</dd>
                        </dl>
                    </div>-->
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        <dd>{{ $profile->street }},</dd>
                                        <dd>{{ $profile->postcode }} , {{ $profile->city }},</dd>
                                        <dd>{{ $profile->state }},</dd>
                                        <dd>{{ $profile->country }},</dd>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Joined date</td>
                                    <td>{{ $profile->profileable->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><a href="mailto:{{ $profile->profileable->email }}">{{ $profile->profileable->email }}</a></td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>
                                        <dd>{{ $profile->contact_no }}</dd>
                                        <dd>{{ $profile->contact_no2 }}</dd>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rank</td>
                                    <td>{{ $profile->profileable->rank->name }}</td>
                                </tr>  
                                <tr>
                                    <td>MyKad/Passport Status</td>
                                    <td>
                                        @if($profile->status_ic == 'Pending')
                                        Pending | <a href="{{ url('profile/upload-ic')}}">Click Here To Upload Your MyKad Or Passport </a>
                                        @else
                                        {{ $profile->status_ic }}
                                        @endif
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
               {{--  <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a> --}}
                <span class="pull-right">
                    <a href="{{ url('/profile/'.$profile->id .'/edit')}}" data-original-title="Update Profile" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"> Update Profile</i></a>
                    {{-- <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a> --}}
                </span>
            </div> 
        </div>
    </div>
</div>
@else
<div class="row">
	<div class="col-md-3">
		<h3>No Profile found. Please update your profile <a href="{{ url('profile/create') }}"> Click Here </a></h3>
	</div>
</div>

@endif

@endsection
