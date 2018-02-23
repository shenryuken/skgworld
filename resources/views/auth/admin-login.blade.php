<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>HOMER | WebApp admin theme</title>

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

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>

{{-- <div class="back-link">
    <a href="index.html" class="btn btn-primary">Back to Dashboard</a>
</div> --}}

<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>PLEASE LOGIN TO APP</h3>
                <small>This Is The Admin Login Page!</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                        <form id="loginForm" method="post" action="{{ route('admin.login.submit') }}">
                        {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label" for="email">E-Mail Address</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you email" required="" value="" name="email" id="email" class="form-control">
                                <span class="help-block small">Your unique email to app</span>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                <span class="help-block small">Your strong password</span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                <label class="control-label">Captcha</label>

                                <div class="pull-center">
                                    {!! app('captcha')->display() !!}

                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="checkbox">
                                <input type="checkbox" class="i-checks" name="remember">
                                     Remember login
                                <p class="help-block small">(if this is a private computer)</p>
                            </div>
                            <button class="btn btn-success btn-block">Login</button>
                            <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                Forgot Your Password?
                            </a>
                            {{-- <a class="btn btn-default btn-block" href="#">Register</a> --}}
                            <br />
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>HOMER</strong> - AngularJS Responsive WebApp <br/> 2015 Copyright Company Name
        </div>
    </div>
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
</body>
</html>