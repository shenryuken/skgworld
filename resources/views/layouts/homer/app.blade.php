<!DOCTYPE html>
<html>
<head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page title -->
    <title>
    @section('title')
        | Homer
    @show 
    </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset("themes/Homer/vendor/fontawesome/css/font-awesome.css") }}" />
    <link rel="stylesheet" href="{{ asset("themes/Homer/vendor/metisMenu/dist/metisMenu.css") }}" />
    <link rel="stylesheet" href="{{ asset("themes/Homer/vendor/animate.css/animate.css") }}" />
    <link rel="stylesheet" href="{{ asset("themes/Homer/vendor/bootstrap/dist/css/bootstrap.css") }}" />

    <!-- App styles -->
    <link rel="stylesheet" href="{{asset("themes/Homer/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css")}}" />
    <link rel="stylesheet" href="{{asset("themes/Homer/fonts/pe-icon-7-stroke/css/helper.css")}}" />
    <link rel="stylesheet" href="{{asset("themes/Homer/styles/style.css")}}">

    @yield('header_styles')
    
</head>
<body class="fixed-navbar fixed-sidebar">

<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
@include('layouts.homer.header')

<!-- Navigation -->
@if(Auth::guard('admin')->user() !== null)
	@include('layouts.homer.admin_navigation')
@elseif(Auth::user() !== null)
	@include('layouts.homer.user_navigation')
@endif

<!-- Main Wrapper -->
<div id="wrapper">

	<div class="content animate-panel">

	    <!-- Main content -->
	    <!-- Your Page Content Here -->
	    @yield('content')
	    <!-- /.content -->

	</div>

	    <!-- Right sidebar -->
	    <div id="right-sidebar" class="animated fadeInRight">

	        <div class="p-m">
	            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
	            </button>
	            <div>
	                <span class="font-bold no-margins"> Analytics </span>
	                <br>
	                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
	            </div>
	            <div class="row m-t-sm m-b-sm">
	                <div class="col-lg-6">
	                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

	                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
	                </div>
	                <div class="col-lg-6">
	                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

	                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
	                </div>
	            </div>
	            <div class="progress m-t-xs full progress-small">
	                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
	                     class=" progress-bar progress-bar-success">
	                    <span class="sr-only">35% Complete (success)</span>
	                </div>
	            </div>
	        </div>
	        <div class="p-m bg-light border-bottom border-top">
	            <span class="font-bold no-margins"> Social talks </span>
	            <br>
	            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
	            <div class="m-t-md">
	                <div class="social-talk">
	                    <div class="media social-profile clearfix">
	                        <a class="pull-left">
	                            <img src="images/a1.jpg" alt="profile-picture">
	                        </a>

	                        <div class="media-body">
	                            <span class="font-bold">John Novak</span>
	                            <small class="text-muted">21.03.2015</small>
	                            <div class="social-content small">
	                                Injected humour, or randomised words which don't look even slightly believable.
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="social-talk">
	                    <div class="media social-profile clearfix">
	                        <a class="pull-left">
	                            <img src="images/a3.jpg" alt="profile-picture">
	                        </a>

	                        <div class="media-body">
	                            <span class="font-bold">Mark Smith</span>
	                            <small class="text-muted">14.04.2015</small>
	                            <div class="social-content">
	                                Many desktop publishing packages and web page editors.
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="social-talk">
	                    <div class="media social-profile clearfix">
	                        <a class="pull-left">
	                            <img src="images/a4.jpg" alt="profile-picture">
	                        </a>

	                        <div class="media-body">
	                            <span class="font-bold">Marica Morgan</span>
	                            <small class="text-muted">21.03.2015</small>

	                            <div class="social-content">
	                                There are many variations of passages of Lorem Ipsum available, but the majority have
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>

	    <!-- Footer-->
	    <footer class="footer">
	        <span class="pull-right">
	            Example text
	        </span>
	        Company 2015-2020
	    </footer>

</div>

<!-- Vendor scripts -->
<script src="{{ asset('themes/Homer/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('themes/Homer/vendor/sparkline/index.js') }}"></script>

<!-- App scripts -->
<script src="{{ asset('themes/Homer/scripts/homer.js') }}"></script>
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->

</body>
</html>
