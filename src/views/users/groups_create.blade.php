@extends('admin::layouts.default')

@section('headline')
    <div>
        <h1>Создание группы</h1>
    </div>
@stop


@section('scripts')
<script src="{{asset('packages/yaro/jarboe/tb-user.js')}}"></script>
<script>
    TBUser.admin_uri = '{{\Config::get('jarboe::admin.uri')}}';
    <?php
    $total = 1;
    $permissions = \Config::get('jarboe::users.permissions', array());
    foreach ($permissions as $perms) {
        $total += count($perms['rights']);
    }
    ?>
    TBUser.groupRequiredFields = '{{$total}}';
</script>
@stop

@section('main')
    <div id="content">
        

<div class="widget-body no-padding">
    <div class="widget-body no-padding" style="margin: -10px;">
       <form id="group-create-form" method="post" class="smart-form" autocomplete="off" action="{{ url(\Config::get('jarboe::admin.uri') .'/tb/users/do-create') }}">    
            <fieldset> 
            <div class="row">
                <section class="col col-6">
                    <label class="input">
                        <input type="text" placeholder="Название" name="name">
                    </label>
                </section>
            </div>
            </fieldset>
            <hr>
            
            <?php $permissions = \Config::get('jarboe::users.permissions', array()); ?>
            @foreach ($permissions as $ident => $info)
            <header style="margin:0; padding-left: 10px;">{{$info['caption']}}</header>
            
            <fieldset style="padding: 14px 14px 5px;">
                <section>
                    <div class="row">
                @foreach ($info['rights'] as $id => $caption)
                    <div class="col col-3">
                        <label class="label">{{$caption}}:</label>
                        <label class="radio">
                            <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="1">
                            <i></i>Разрешить</label>
                        <label class="radio">
                            <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="0">
                            <i></i>Запретить</label>
                    </div>
                @endforeach
                    </div>
                </section>
            </fieldset>
            <hr>
            @endforeach
            
            <footer>
            <a href="{{ url(\Config::get('jarboe::admin.uri') .'/tb/groups') }}">
            <button type="button" class="btn btn-default">
                Назад
            </button>
            </a>
            <button type="button" class="btn btn-primary" onclick="TBUser.doCreateGroup();">
                Создать
            </button>
        </footer>
            
      </form>  
    </div>
        
    </div>
@stop