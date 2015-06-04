
<form id="locked-screen-form" class="smart-form animated flipInY" action="{{url('login')}}" style="width: 450px;margin: 100px auto 0;">
    <header>
    </header>

    <fieldset>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
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

