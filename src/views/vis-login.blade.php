@extends('admin::layouts.vis-login')


@section('header')
@stop

@section('footer')
@stop


@section('main')

<style type="text/css">
.tbfavicon:hover {
    height: 50px !important;
    margin-top: -20px;
}
</style>
    
    <div id="main" role="main">
        <!-- MAIN CONTENT -->
        <div id="content" class="container">
             
                <div class="b-login col-xs-12 col-sm-12 col-md-5 col-lg-4 " style="float: right;">
                    
                        
                    <div class="b-top">
                        <?php $topBlock = \Config::get('jarboe::login.top_block'); echo $topBlock(); ?>
                    </div>
                    <div class="b-bottom">
                        <?php $bottomBlock = \Config::get('jarboe::login.bottom_block'); echo $bottomBlock(); ?>
                    </div>
                    
                    <div class="well no-padding">
                        @if (\Session::has('tb_login_not_found'))
                            <div class="alert alert-danger fade in">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa-fw fa fa-times"></i>
                                {{\Session::pull('tb_login_not_found')}}
                            </div>
                        @endif
                        
                        <form action="{{url('login')}}" id="login-form" class="smart-form client-form" method="post" {{ \Config::get('jarboe::login.is_active_autocomplete') ?: 'readonly onfocus="this.removeAttribute(\'readonly\');"' }} >
                            <header>
                                {{trans('jarboe::login.sign_in')}}
                                <img class="tbfavicon pull-right" style="height:25px;" src="<?php $faviconUrl = \Config::get('jarboe::login.favicon_url'); echo $faviconUrl(); ?>" />
                            </header>
    
                            <fieldset>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" {{ \Config::get('jarboe::login.is_active_autocomplete') ?: 'readonly onfocus="this.removeAttribute(\'readonly\');"' }} >
                                <section>
                                    <label class="label">{{trans('jarboe::login.email')}}</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email" {{ \Config::get('jarboe::login.is_active_autocomplete') ?: 'readonly onfocus="this.removeAttribute(\'readonly\');"' }} >
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> {{trans('jarboe::login.email_tooltip')}}</b></label>
                                </section>
    
                                <section>
                                    <label class="label">{{trans('jarboe::login.password')}}</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password" {{ \Config::get('jarboe::login.is_active_autocomplete') ?: 'readonly onfocus="this.removeAttribute(\'readonly\');"' }} >
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{trans('jarboe::login.password_tooltip')}}</b> </label>
                                    
                                    {{--
                                    <div class="note">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                    --}}
                                </section>
                                
                                @if (\Config::get('jarboe::login.is_active_remember_me'))
                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember" checked="checked">
                                        <i></i>{{trans('jarboe::login.remember_me')}}</label>
                                </section>
                                @endif
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary submit_button">
                                    {{trans('jarboe::login.sign_in')}}
                                </button>
                            </footer>
                        </form>
    
                    </div>
                        
                </div>
            
        </div>
    </div>


@stop

