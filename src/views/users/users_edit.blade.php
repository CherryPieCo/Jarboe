@extends('admin::layouts.default')

@section('headline')
    <div>
        <h1>Пользователь #{{$user->id}}: {{$user->getFullName()}}</h1>
    </div>
@stop


@section('scripts')
<script src="{{asset('packages/yaro/table-builder/tb-user.js')}}"></script>
<script>
    TBUser.admin_uri = '{{\Config::get('table-builder::admin.uri')}}';
    TBUser.id_user   = '{{$user->id}}';
</script>
@stop

@section('main')
    <div id="content">
        


<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
		<div class="row">
			<div class="col-sm-6">
				<button id="enable" class="btn btn btn-default">
					enable / disable
				</button>
			</div>
			
		</div>
	</div>
	

	<form id="user-update-form" method="post" class="smart-form" novalidate="novalidate" action="{{ url(\Config::get('table-builder::admin.uri') .'/tb/users/update') }}">
		<fieldset>
			<div class="row">
                <section class="col col-2">
                    <img id="tbu-avatar" src="{{ asset($user->image ? : '/packages/yaro/table-builder/img/blank_avatar.gif') }}" style="height:150px;">
                    <input id="tbu-image-input" type="hidden" name="image" value="{{$user->image}}">
                    <br>
                    <div class="input input-file" style="width:150px;">
                        <span class="button" style="width: 114px;top: 5px;line-height: 21px;text-align: center;">
                            <input type="file" id="file" accept="image/*" onchange="TBUser.uploadImage('{{$user->id}}', this.files[0]);">
                            Загрузить
                        </span>
                        <input type="text" placeholder="" readonly="">
                    </div>
                </section>
                
                <section class="col col-10">
                    <div class="row">
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                <input type="text" name="first_name" placeholder="First name" value="{{$user->first_name}}">
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                <input type="text" name="last_name" placeholder="Last name" value="{{$user->last_name}}">
                            </label>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                <input type="email" name="email" placeholder="E-mail" value="{{$user->email}}">
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" value="" autocomplete="off">
                            </label>
                        </section>
                    </div>
                    
                    <div class="row">
                        <section class="col col-6">
                            <label class="checkbox">
                                <input type="checkbox" 
                                    name="activated"
                                    @if ($user->isActivated())
                                        checked="checked"
                                    @endif
                                    ><i></i>
                                Активен
                            </label>
                        </section>
                    </div>    
                    <div class="row">
                        <section class="col col-6">
                            <label class="checkbox">
                                <input type="checkbox" 
                                    name="is_subscribed"
                                    @if ($user->is_subscribed)
                                        checked="checked"
                                    @endif
                                    ><i></i>
                                Подписан на рассылку
                            </label>
                        </section>
                    </div>
                </section>
            </div>
            
            
        </fieldset>    
            
            
            
            
        <footer>
        	<a href="{{ url(\Config::get('table-builder::admin.uri') .'/tb/users') }}">
            <button type="button" class="btn btn-default">
                Назад
            </button>
            </a>
            <button type="button" class="btn btn-primary" onclick="TBUser.doEdit('{{$user->id}}');">
                Сохранить
            </button>
        </footer>
                                            
	</form>
</div>


    </div>
@stop