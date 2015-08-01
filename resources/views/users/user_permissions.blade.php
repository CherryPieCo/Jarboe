
<?php $permissions = config('jarboe.c.users.permissions', []); ?>
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
                <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="-1">
                <i></i>Запретить</label>
            <label class="radio">
                <input type="radio" name="permissions[{{$ident}}][{{$id}}]" value="0">
                <i></i>Наследовать</label>
        </div>
    @endforeach
        </div>
    </section>
</fieldset>
<hr>
@endforeach