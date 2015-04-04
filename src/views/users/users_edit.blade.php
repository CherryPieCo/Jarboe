@extends('admin::layouts.default')

@section('headline')
    <div>
        <h1>Пользователь #{{$user->id}}: {{$user->first_name}} {{$user->last_name}}</h1>
    </div>
@stop


@section('scripts')
<script src="{{asset('packages/yaro/jarboe/tb-user.js')}}"></script>
<script>
    TBUser.admin_uri = '{{\Config::get('jarboe::admin.uri')}}';
    TBUser.id_user   = '{{$user->id}}';
</script>
@stop

@section('main')
    <div id="content">
        

<div class="widget-body no-padding">
    <form id="user-update-form" method="post" class="smart-form" novalidate="novalidate" action="{{ url(\Config::get('jarboe::admin.uri') .'/tb/users/update') }}">
        
    <ul class="nav nav-tabs tabs-pull-right bordered">
        <li class="pull-right">
            <a href="#l3" data-toggle="tab">Группы</a>
        </li>
        <li class="pull-right">
            <a href="#l1" data-toggle="tab">Права</a>
        </li>
        <li class="active">
            <a href="#l2" data-toggle="tab" class="active">Карточка</a>
        </li>
    </ul>
    
    <div class="tab-content padding-10">
        <div class="tab-pane" id="l1">
            <div class="widget-body no-padding" style="margin: -10px;">
                
            <?php $permissions = \Config::get('jarboe::users.permissions', array()); ?>
            @foreach ($permissions as $ident => $info)
            <header style="margin:0px 0 0; padding-left: 10px;">{{$info['caption']}}</header>
            
            <fieldset style="padding: 14px 14px 5px;">
                <section>
                    <div class="row">
                @foreach ($info['rights'] as $id => $caption)
                    <?php 
                    $type = $ident .'.'. $id;
                    // HACK: 0 stands for inheritance, that doesnt saving to db
                    $perm = isset($userPermissions[$type]) ? $userPermissions[$type] : 0;
                    ?>
                    <div class="col col-3">
                        <label class="label">{{$caption}}:</label>
                        <label class="radio">
                            <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="1" @if($perm === 1) checked="checked" @endif>
                            <i></i>Разрешить</label>
                        <label class="radio">
                            <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="-1" @if($perm === -1) checked="checked" @endif>
                            <i></i>Запретить</label>
                        <label class="radio">
                            <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="0" @if($perm === 0) checked="checked" @endif>
                            <i></i>Наследовать</label>
                    </div>
                @endforeach
                    </div>
                </section>
            </fieldset>
            <hr>
            @endforeach
            </div>
        </div>
        
        <!-- start tab 2 -->
        <div class="tab-pane active" id="l2">
            <div class="widget-body no-padding" style="margin: -10px;">
            {{--
                <div class="widget-body-toolbar">
                    <div class="row">
                        <div class="col-sm-6">
                            <button id="enable" class="btn btn btn-default">
                                enable / disable
                            </button>
                        </div>
                        
                    </div>
                </div>
            --}}
                
                    <fieldset>
                        <div class="row">
                            <section class="col col-2">
                                <img id="tbu-avatar" src="{{ asset($user->image ? : '/packages/yaro/jarboe/img/blank_avatar.gif') }}" style="height:150px;">
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
                                            <input type="email" name="email" placeholder="E-mail" value="{{$user->email}}" autocomplete="off">
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
                                                @if ($user->is_subscribed)
                                                    checked="checked"
                                                @endif
                                                name="is_subscribed"><i></i>
                                            Подписан на рассылку
                                        </label>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </fieldset>    
            </div>
        </div>
        <!-- end tab 2 -->
        
        
        <div class="tab-pane" id="l3">
            <div class="widget-body no-padding" style="margin: -10px;">
                <header style="margin:0px 0 0; padding-left: 10px;">Группы пользователя</header>
                <fieldset style="padding: 14px 14px 5px;">
                    <section>
                        <div class="row">
                            <div class="col col-4">
                                @foreach ($groups as $group)
                                <label class="checkbox">
                                    <input type="checkbox" 
                                           @if (in_array($group->name, $userGroups, true))
                                            checked="checked" 
                                           @endif
                                           name="groups[{{ $group->id }}]">
                                    <i></i>{{ $group->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </fieldset> 
            </div>
        </div>
        
        </div>    
        
        <footer>
            <a href="{{ url(\Config::get('jarboe::admin.uri') .'/tb/users') }}">
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
@stop