

<div class="">

    <table class="tbb" style="width: 100%;border-collapse: separate; border-spacing: 2px;">
    <thead>
        <tr>
            <th>
                <a href="javascript:void(0);" onclick="m2m4{{$name}}{{$postfix}}.addRow(this);" type="button" class="btn btn-info btn-sm">Добавить</a>
                
                <textarea style="display: none;">
                    <tr>
                        <td style="min-width: 180px; padding-right: 10px;">
                            <select style="width: 100%;" class="select2-enabled {{$name}}{{$postfix}}-select2" name="{{$name}}[#{i}][id]" id="many2many-{{$name}}{{$postfix}}-#{i}">
                                @foreach ($options as $idOption => $option)
                                    <option value="{{$idOption}}">
                                        {{ trim($option['value']) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        @foreach ($extra as $field => $fieldInfo)
                        <td style="padding-right: 10px;">
                            @if ($fieldInfo['type'] == 'text')
                                <input style="width: auto;" value="" 
                                       name="{{$name}}[#{i}][{{$field}}]" 
                                       class="dblclick-edit-input form-control input-sm unselectable"></input>
                            @elseif ($fieldInfo['type'] == 'select')
                                <select style="width: auto;" name="{{$name}}[#{i}][{{$field}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                    <?php reset($fieldInfo['options']); $firstOptionIdent = key($fieldInfo['options']); ?>
                                    @foreach ($fieldInfo['options'] as $optionIdent => $optionCaption)
                                        <option value="{{ $optionIdent }}" {{ $optionIdent == $firstOptionIdent ? 'selected="selected"' : '' }}>
                                            {{ $optionCaption }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <a href="javascript:void(0);" onclick="m2m4{{$name}}{{$postfix}}.delRow(this);" type="button" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                </textarea>
                
            </th>
            
            @foreach ($extra as $field => $fieldInfo)
                <th>{{ $fieldInfo['caption'] }}</th>
            @endforeach
            
            <th style="width:1%;"></th>
        </tr>
    </thead>
    <tbody>
    
        <?php $i = 1; ?>
        @foreach ($selected as $idSelected => $info)
        <tr>
            <td style="min-width: 180px; padding-right: 10px;">
                <select style="width: 100%;" class="select2-enabled {{$name}}{{$postfix}}-select2" name="{{$name}}[{{$i}}][id]" id="many2many-{{$name}}{{$postfix}}-{{$i}}">
                    @foreach ($options as $idOption => $option)
                        <option value="{{$idOption}}" 
                                @if ($idSelected == $idOption)
                                    selected="selected"
                                @endif
                                >
                            {{ trim($option['value']) }}
                        </option>
                    @endforeach
                </select>
            </td>
            
            @foreach ($extra as $field => $fieldInfo)
            <td style="padding-right: 10px;">
                @if ($fieldInfo['type'] == 'text')
                    <input style="width: auto;" 
                           value="{{$info['info'][$field]}}" 
                           name="{{$name}}[{{$i}}][{{$field}}]" 
                           class="dblclick-edit-input form-control input-sm unselectable"></input>
                @elseif ($fieldInfo['type'] == 'select')
                    <select style="width: auto;" name="{{$name}}[{{$i}}][{{$field}}]" class="dblclick-edit-input form-control input-sm unselectable">
                        @foreach ($fieldInfo['options'] as $optionIdent => $optionCaption)
                            <option value="{{ $optionIdent }}" {{ $optionIdent == $info['info'][$field] ? 'selected="selected"' : '' }}>
                                {{ $optionCaption }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </td>
            @endforeach
            
            <td>
                <a href="javascript:void(0);" onclick="m2m4{{$name}}{{$postfix}}.delRow(this);" type="button" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
            </td>
            
        </tr>
        <?php ++$i; ?>
        @endforeach
        
        
    </tbody>
    </table>
    

</div>

<script>

var m2m4{{$name}}{{$postfix}} = 
{
    i: 0,
    name: '{{$name}}',
    addRow: function(context) {
        var $inp = jQuery(context).parent().find('textarea').val();
        var tr = $inp.replace(/#\{i\}/g, this.i);
    
        jQuery(context).parent().parent().parent().parent().find('tbody').prepend(tr);
    
        
        this.i = this.i + 1;
        jQuery("select.{{$name}}{{$postfix}}-select2").select2(); 
        TableBuilder.initSelect2Hider();
    }, // end addRow
    
    delRow: function(context) {
        // FIXME: confirm
        jQuery(context).parent().parent().remove();
    }, // end delRow
    
}; // auto-generated

m2m4{{$name}}{{$postfix}}.i = {{$i}};

jQuery(document).ready(function() {
    jQuery("select.{{$name}}{{$postfix}}-select2").select2(); 
});
</script>