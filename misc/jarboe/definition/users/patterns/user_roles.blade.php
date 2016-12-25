
<div class="row">
    @foreach ($roles as $role)
        <div class="col col-4">
            <label class="checkbox">
                <input type="checkbox" name="pattern[user_roles][{{$role->id}}]" value="{{$role->id}}" {{ $user && $user->inRole($role) ? 'checked="checked"' : '' }}>
                <i></i> {{$role->name}}
            </label>
        </div>
    @endforeach
</div>
