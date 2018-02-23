@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    My Profile
    @parent
@stop
<?php $page_title = 'My Profile'; ?>
@section('content')

@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->profile !== null)
<div class="row">
    <div class="col-lg-4" style="">
        <div class="hpanel hgreen">
            <div class="panel-body">
                <div class="pull-right text-right">
                    <div class="btn-group">
                        <a href="{{ url('admin/profile/'.$user->id .'/edit')}}"><i class="fa fa-edit btn btn-default btn-xs"></i></a>
                    </div>
                </div>
                <img alt="logo" class="img-circle m-b m-t-md" src="{{ asset('themes/Joli/assets/images/users/avatar.jpg') }}">
                <h3><a href="">{{ $user->username }}</a></h3>
                <div class="text-muted font-bold m-b-xs">California, LA</div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                </p>
                <div class="progress m-t-xs full progress-small">
                    <div style="width: 65%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="65" role="progressbar" class=" progress-bar progress-bar-success">
                        <span class="sr-only">35% Complete (success)</span>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <dl>
                    <dt>Address</dt>
                    <dd>{{ $profile->street }},</dd>
                    <dd>{{ $profile->postcode }} , {{ $profile->city }},</dd>
                    <dd>{{ $profile->state }},</dd>
                    <dd>{{ $profile->country }},</dd><br/>
                    
                    <dt> Contact Details </dt>
                    <dd> Email : {{ $user->email }} 
                        <a href="http://localhost/laravel54/public/change-email">
                            <i class="fa fa-edit btn btn-default btn-xs"></i>
                        </a>
                    </dd>
                    <dd> Phone : {{ $profile->contact_no }} </dd>
                    @if(isset($profile->contact_no2) && $profile->contact_no2 != null)
					<dd> Phone : {{ $profile->contact_no2 }} </dd>
                    @endif
                    
                    <br/>
                    <dt>Rank</dt>
                    <dd>
                    @foreach($user->roles as $role) 
                        {{ $role->name }}
                    @endforeach
                    </dd>

                    <br/>
                    <dt>Date Joined</dt>
                    <dd>{{ $user->created_at }}</dd>
                </dl>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">
                    <div class="col-md-4 border-right" style="">
                        <div class="contact-stat"><span>Sales: </span> <strong>200</strong></div>
                    </div>
                    <div class="col-md-4 border-right" style="">
                        <div class="contact-stat"><span>Referrals: </span> <strong>300</strong></div>
                    </div>
                    <div class="col-md-4" style="">
                        <div class="contact-stat"><span>Views: </span> <strong>400</strong></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
 
@else
<div class="row">
	<div class="col-md-3">
		<h3>No Profile found. Please update your profile <a href="{{ url('admin/create-profile') }}"> Click Here </a></h3>
	</div>
</div>

@endif

@endsection