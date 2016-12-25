
<div class="inline-group">
    <label class="radio">
        <input type="radio" name="pattern[user_activation]" value="activate" @if ($isActive) checked="checked" @endif >
        <i></i>Активировать</label>
        
    <label class="radio">
        <input type="radio" name="pattern[user_activation]" value="deactivate" @if (!$isActive) checked="checked" @endif >
        <i></i>Деактивировать</label>
</div>
