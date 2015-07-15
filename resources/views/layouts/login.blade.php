<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title>{{{ \Config::get('jarboe::admin.caption') }}}</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Use the correct meta names below for your web application
             Ref: http://davidbcalhoun.com/2010/viewport-metatag 
             
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">-->
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/bootstrap.min.css')}}"> 
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/font-awesome.min.css')}}">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-production.css')}}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-skins.css')}}">  
        
        <!-- SmartAdmin RTL Support is under construction
            <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.css"> -->
        
        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/demo.css')}}">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="{{ \Config::get('jarboe::admin.favicon_url') }}" type="image/x-icon">
        <link rel="icon" href="{{ \Config::get('jarboe::admin.favicon_url') }}" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/trianglify/0.1.5/trianglify.min.js"></script>
        
        <style>
            {{--
            body#login {
                background: url('/packages/yaro/jarboe/img/backs/{{rand(1,18)}}.png') #f4f4f4;
            }
            --}}
            div#main {
                background: none !important;
            }
            #login #header #logo {
                font-size: 34px;
                font-family: "Open Sans",Arial,Helvetica,Sans-Serif;
                line-height: 30px;
                font-weight: 300;
            }
        </style>
    </head>
    
    <body id="login" class="animated fadeInDown">

        @yield('main')
        
        <script>
            var t = new Trianglify();
            var pattern = t.generate(document.body.clientWidth + 200, document.body.clientHeight + 200);
            document.body.setAttribute('style', 'background-image: '+pattern.dataUrl);
        </script>
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

