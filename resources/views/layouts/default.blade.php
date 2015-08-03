<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title>{{{ config('jarboe.admin.caption') }}}</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <link rel="shortcut icon" href="{{ config('jarboe.admin.favicon_url') }}" type="image/x-icon">
        <link rel="icon" href="{{ config('jarboe.admin.favicon_url') }}" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        
        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
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
    <body class="{{ \Cookie::get('tb-misc-body_class', '') }}">
    
        <style>
        .bigBox {
            z-index: 9100001;
        }
        .image_storage_wrapper {
          width: 100%;
          height: 100%;
          z-index: 999901;
          position: fixed;
          top: 0;
          left: 0;
          overflow: auto;
          background: #fff;
        }
        .image_storage_wrapper .close_image_storage {
          position: absolute;
          top: 3px;
          right: 3px;
          z-index: 9;
        }
        .divMessageBox {
            z-index: 999981;
        }
        </style>
        
        <div id="modal_wrapper"></div>
        @yield('table_form')
        
        <div class="image_storage_wrapper" style="display:none;">
            @include('admin::tb.storage.image.preloader')
            <div class="close_image_storage">
                <a href="javascript:void(0);" onclick="TableBuilder.closeImageStorageModal();" class="btn btn-info btn-xs"><i class="fa fa-times"></i></a>
            </div>
            <div id="modal_image_storage_wrapper" style="padding: 30px 40px;"></div>
        </div>
        
        
        @include('admin::partials.header')
        @include('admin::partials.navigation')

        <!-- MAIN PANEL -->
        <div id="main" role="main">
        
            <div id="main-content">
                <div id="ribbon">
                    @yield('ribbon')
                </div>
                
                <div id="content">
                    @yield('headline')
                    @yield('main')
                </div>
            </div>
            
            <div id="locked-screen" style="display: none;  position: fixed; top: 0; right: 0; z-index: 9999999; height: 100%; background-color: #fff;width: 100%;">
                @include('admin::partials.locked_screen')
            </div>
        </div>
        <!-- END MAIN PANEL -->
        
        
        
        
        @include('admin::partials.shortcut')

        @include('admin::partials.scripts')
        
        @yield('scripts')
        
    </body>

</html>