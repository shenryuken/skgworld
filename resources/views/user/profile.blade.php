@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Admin List
    @parent
@stop
<?php $page_title = 'Dashboard'; ?>
@section('content')

@if((Auth::guard('web')->check() && Auth::guard('web')->user()->profile !== null) || (Auth::guard('admin')->check() && Auth::guard('admin')->user()->profile !== null))
<div class="row">
    <div class="col-lg-4" style="">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right text-right">
                    <div class="btn-group">
                        <a href="{{ url('user/profile/'.$user->id .'/edit')}}"><i class="fa fa-edit btn btn-default btn-xs"></i></a>
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
                    <dd>{{ $user->rank->name }}</dd>

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
    <div class="col-lg-8" style="">
        <div class="hpanel">
            <div class="hpanel">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Bonus</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Store</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <strong>Lorem ipsum dolor sit amet, consectetuer adipiscing</strong>

                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of
                            existence in this spot, which was created for the bliss of souls like mine.</p>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Bonus </th>
                                    <th>Qualify Rank </th>
									<th>Minimum Qualify </th>
                                  	<th>Qualify</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Retail Price</td>
                                    <td>MO, DO, SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Personal Rebate</td>
                                    <td>LC, MO, DO, SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Direct Sponsor</td>
                                    <td>MO, DO, SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>3 Generation Group Bonus</td>
                                    <td>DO, SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>DO CTO 8%</td>
                                    <td>DO</td>
                                    <td>4000 GPV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>SDO CTO 5%</td>
                                    <td>SDO</td>
                                    <td>5 Branch, Each Branch 5000 GPV </td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>SDO Bonus</td>
                                    <td>SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>SDO To SDO Bonus 2%</td>
                                    <td>SDO</td>
                                    <td>100 PV</td>
                                    <td><span class="pie" style="display: none;">{{ $user->wallet->pv}}/100</span><svg class="peity" height="16" width="16"><path d="M 8 0 A 8 8 0 0 1 10.205098846535993 0.30990643249344885 L 8 8" fill="#62cb31"/><path d="M 10.205098846535993 0.30990643249344885 A 8 8 0 1 1 7.999999999999998 0 L 8 8" fill="#edf0f5"/></svg></td>
                                    <td><a href="#"><i class="fa fa-check text-success"></i></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body no-padding">


                        <div class="chat-discussion" style="height: auto">

                            <div class="chat-message">
                                <img class="message-avatar" src="images/a1.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date"> Mon Jan 26 2015 - 18:39:23 </span>
                                            <span class="message-content">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                            </span>

                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-success"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a4.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Karl Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Message</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a2.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.
                                            </span>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a5.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Alice Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> Nudge</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a6.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Mark Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-success"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a4.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Karl Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Message</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a2.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.
                                            </span>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a5.jpg" alt="">
                                <div class="message">
                                    <a class="message-author" href="#"> Alice Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
											All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            </div>
        </div>
    </div>
</div>
@else
<div class="row">
	<div class="col-md-3">
		<h3>No Profile found. Please update your profile <a href="{{ url('user/create_profile') }}"> Click Here </a></h3>
	</div>
</div>

@endif

@endsection