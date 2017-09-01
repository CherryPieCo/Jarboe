
@foreach ($permissions as $ident => $info)
<header style="margin:0px 0 0; padding-left: 10px;">{{$info['caption']}}</header>

<fieldset style="padding: 14px 14px 5px;">
    <section>
        <div class="row">
    @foreach ($info['rights'] as $id => $caption)
        <?php 
        $type = $ident .'.'. $id;
        $perm = array_key_exists($type, $groupPermissions) ? $groupPermissions[$type] : false;
        ?>
        <div class="col col-3">
            <label class="label">{{$caption}}:</label>
            <label class="radio">
                <input type="radio" name="pattern[role_permissions][{{$ident}}][{{$id}}]" value="allow" @if($perm === true) checked="checked" @endif>
                <i></i>Разрешить</label>
            <label class="radio">
                <input type="radio" name="pattern[role_permissions][{{$ident}}][{{$id}}]" value="deny" @if($perm === false) checked="checked" @endif>
                <i></i>Запретить</label>
        </div>
    @endforeach
        </div>
    </section>
</fieldset>
<hr>
@endforeach