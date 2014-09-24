@extends('admin::layouts.login')


@section('header')
@stop

@section('footer')
@stop


@section('main')
    <header id="header">
        <span id="logo">{{ Config::get('table-builder::admin.title') }}</span>

        <!--<div id="logo-group">

        </div>-->


    </header>
    
    <div id="main" role="main">

        <!-- MAIN CONTENT -->
        <div id="content" class="container">

            
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4" style="float: right;">
                    <div class="well no-padding">
                        <form action="{{url('login')}}" id="login-form" class="smart-form client-form" method="post">
                            <header>
                                Sign In
                            </header>

                            <fieldset>
                                
                                <section>
                                    <label class="label">E-mail</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address</b></label>
                                </section>

                                <section>
                                    <label class="label">Password</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
                                    
                                    {{--
                                    <div class="note">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                    --}}
                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember">
                                        <i></i>Stay signed in</label>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    Sign in
                                </button>
                            </footer>
                        </form>

                    </div>
                    
                    
                    
                </div>
            </div>
        </div>

    </div>

@stop

