<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">

        <title>{{{ \Config::get('jarboe::admin.caption') }}}</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/bootstrap.min.css')}}"> 
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/font-awesome.min.css')}}">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-production.css')}}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-skins.css')}}">  
        
        
        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/demo.css')}}">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="{{ \Config::get('jarboe::admin.favicon_url') }}" type="image/x-icon">
        <link rel="icon" href="{{ \Config::get('jarboe::admin.favicon_url') }}" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        
        <style>
            #login #main {
                background: #667;
            }
            body#login {
                padding: 0 !important;
            }
            div.b-login {
                background: #fff;
                opacity: 0.9;
                position: fixed;
                height: 100%;
                right: 0;
                top: 0;
                min-height: 480px;
            }
            div#main {
                min-height: 100%;
                background-image: url('<?php $bg = \Config::get('jarboe::login.background_url'); echo $bg(); ?>') !important;
                background-size: cover !important;
            }
            div#content {
                margin-right: 0;
                padding: 0;
            }
            #login #header #logo {
                font-size: 34px;
                font-family: "Open Sans",Arial,Helvetica,Sans-Serif;
                line-height: 30px;
                font-weight: 300;
            }
            .client-form header {
                border-bottom-style: solid;
                background: #fff;
            }
            .well {
                border: none;
                box-shadow: none;
                margin-top: 80px;
            }
            .smart-form footer {
                background: #fff;
            }
            form.smart-form{
                padding: 0 15px;
            }
            .b-top {
                position: absolute;
                z-index: 9;
                top: 25px;
                right: 0px;
                width: 100%;
                padding: 0 40px;
                line-height: 12px;
            }
            .b-bottom {
                position: absolute;
                z-index: 9;
                right: 0px;
                bottom: 10px;
                z-index: 6;
                width: 100%;
                padding: 0 40px;
                line-height: 12px;
            }
            .smart-form .btn.submit_button {
                float: left;
                margin-left: 0;
            }
            
            @media(min-width:1200px){
                .col-lg-4 {
                    width: 29%;
                }
                .well {
                    margin-top: 130px;
                }
            }
        </style>
    </head>
    
    <body id="login" class="">

        @yield('main')
        
        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script> if (!window.jQuery) { document.write('<script src="{{asset('packages/yaro/jarboe/js/libs/jquery-2.0.2.min.js')}}"><\/script>');} </script>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script> if (!window.jQuery.ui) { document.write('<script src="{{asset('packages/yaro/jarboe/js/libs/jquery-ui-1.10.3.min.js')}}"><\/script>');} </script>

        <!-- JQUERY VALIDATE -->
        <script src="{{asset('packages/yaro/jarboe/js/plugin/jquery-validate/jquery.validate.min.js')}}"></script>

        <script type="text/javascript">
            //runAllForms();
            //jQuery(document).ready(function(){
                jQuery(function() {
                    // Validation
                    jQuery("#login-form").validate({
                        // Rules for form validation
                        rules : {
                            email : {
                                required : true,
                                email : true
                            },
                            password : {
                                required : true,
                                minlength : 3,
                                maxlength : 20
                            }
                        },
    
                        // Messages for form validation
                        messages : {
                            email : {
                                required : '{{trans('jarboe::login.email_required')}}',
                                email : '{{trans('jarboe::login.email_valid')}}'
                            },
                            password : {
                                required : '{{trans('jarboe::login.password_required')}}'
                            }
                        },
    
                        // Do not change code below
                        errorPlacement : function(error, element) {
                            error.insertAfter(element.parent());
                        }
                    });
                });
            //});
        </script>
        
    </body>
</html>

