<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->           
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Page title -->
        <title>
        @section('title')
            | SKG WORLD
        @show 
        </title>
        
        <!-- <link rel="icon" href="favicon.ico" type="image/x-icon" /> -->
        <link rel="icon" href="{{ asset('themes/Joli/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('themes/Joli/css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->
        <style type='text/css'>
        iframe.goog-te-banner-frame{ display: none !important;}
        </style>

        <style type='text/css'>
        body {position: static !important; top:0px !important;}
        </style>

        <style type='text/css'>
        .goog-logo-link {display:none !important;} 
        .goog-te-gadget{color: transparent !important;}
        </style>

        @yield('header_styles')
        
        
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                @if(Auth::guard('admin')->user() !== null)
                    @include('layouts.joli.admin_navigation')
                @elseif(Auth::user() !== null)
                    @include('layouts.joli.user_navigation')
                @endif
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->   
                    <div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,ms,zh-CN,zh-TW', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>                 
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Link</a></li>                    
                    <li class="active">Active</li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> {{ $page_title }}</h2>
                </div>     
                <br>              
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    @yield('content')
                
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ asset('themes/Joli/audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ asset('themes/Joli/audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->                 
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
        <!-- END PLUGINS -->
        <!-- begin page level js -->
        @yield('footer_scripts')
        <!-- end page level js -->
        <!-- START TEMPLATE -->
       
        <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('themes/Joli/js/actions.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('themes/Joli/js/dashboard_chart.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('js/proajax.js')}}"></script></s>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>



