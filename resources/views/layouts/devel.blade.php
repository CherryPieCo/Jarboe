<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title></title>
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
        {{--
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-production.css')}}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/smartadmin-skins.css')}}">
        --}}
        <!-- SmartAdmin RTL Support is under construction
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.css"> -->

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update.
        <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        {{--
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/demo.css')}}">
        --}}
        
        <!-- FAVICONS -->
        <link rel="shortcut icon" href="{{asset('packages/yaro/jarboe/img/favicon/favicon.ico')}}" type="image/x-icon">
        <link rel="icon" href="{{asset('packages/yaro/jarboe/img/favicon/favicon.ico')}}" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        
        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="{{asset('packages/yaro/jarboe/js/libs/jquery-2.0.2.min.js')}}"><\/script>');
            }
        </script>
        
        
        <script src="{{asset('packages/yaro/jarboe/table-builder.js')}}"></script>
        <link rel="stylesheet" href="{{asset('packages/yaro/jarboe/table-builder.css')}}">
        
        <script src="{{asset('packages/yaro/jarboe/tb-menu.js')}}"></script>

        <link rel="stylesheet" href="{{asset('packages/yaro/jarboe/css/smartadmin-production.min.css')}}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('packages/yaro/jarboe/css/your_style.css')}}">
    
        @yield('styles')
        
    </head>
    <body class="hidden-menu">
        

        <!-- MAIN PANEL -->
        <div id="main" role="main">
        
            
            <div id="content">
                @yield('headline')
                @yield('main')
            </div>
        </div>
        <!-- END MAIN PANEL -->
        
        
        @include('admin::partials.shortcut')

        @include('admin::partials.scripts')
        
        @yield('scripts')
        
    </body>

</html>