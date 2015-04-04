@extends('admin::layouts.login')


@section('header')
@stop

@section('footer')
@stop


@section('main')
    <header id="header">
        <span id="logo">{{ Config::get('jarboe::admin.title') }}</span>

        <!--<div id="logo-group">

        </div>-->


    </header>
    
    <div id="main" role="main">

        <!-- MAIN CONTENT -->
        <div id="content" class="container">

            
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4" style="float: right;">
                @if (\Session::has('tb_login_not_found'))
                    <div class="alert alert-danger fade in">
                        <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="fa-fw fa fa-times"></i>
                        {{\Session::pull('tb_login_not_found')}}
                    </div>
                @endif
                
                    <div class="well no-padding">
                        <form action="{{url('login')}}" id="login-form" class="smart-form client-form" method="post">
                            <header>
                                {{trans('jarboe::login.sign_in')}}
                            </header>

                            <fieldset>
                                
                                <section>
                                    <label class="label">{{trans('jarboe::login.email')}}</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> {{trans('jarboe::login.email_tooltip')}}</b></label>
                                </section>

                                <section>
                                    <label class="label">{{trans('jarboe::login.password')}}</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{trans('jarboe::login.password_tooltip')}}</b> </label>
                                    
                                    {{--
                                    <div class="note">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                    --}}
                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember">
                                        <i></i>{{trans('jarboe::login.remember_me')}}</label>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    {{trans('jarboe::login.sign_in')}}
                                </button>
                            </footer>
                        </form>

                    </div>
                    
                    
                    
                </div>
            </div>
        </div>

    </div>

@stop

