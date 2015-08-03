

<table>
<tbody>
    <?php foreach($options as $setIdent => $caption): ?>
        <tr style="white-space: nowrap;">
        <td>
            <span class="">
                {{$caption}}: 
            </span>
        </td>
        <td>
            <span class="onoffswitch">
                <input onchange="TableBuilder.sendInlineEditForm(this, '{{$name}}', {{$row['id']}});" type="checkbox" 
                        name="{{$name}}[{{$setIdent}}]" 
                        class="onoffswitch-checkbox" 
                        @if (in_array($setIdent, $selected)) checked="checked" @endif 
                        id="{{$row['id']}}-{{$name}}-{{$setIdent}}">
                <label class="onoffswitch-label" for="{{$row['id']}}-{{$name}}-{{$setIdent}}"> 
                    <span class="onoffswitch-inner" data-swchon-text="ДА" data-swchoff-text="НЕТ"></span> 
                    <span class="onoffswitch-switch"></span> 
                </label> 
            </span>
        </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>

