

<?php 
// arrayImageHack 
$aig = isset($is_multiple) && $is_multiple ? '['. uniqid(42, true) .']' : '';
?>

<div style="position: relative; display: inline-block;">
    
    <img class="image-attr-editable" 
         height="80px" 
         onclick="TableBuilder.toggleImagePopover(this);" 
         src="{{ asset($data['sizes']['original']) }}" />
         
    <div class="tb-btn-delete-wrap">
        <button class="btn btn-default btn-sm tb-btn-image-delete" 
                type="button" 
                onclick="TableBuilder.deleteImage('{{ $name }}', this);">
            <i class="fa fa-times"></i>
        </button>
    </div>
    
    @foreach ($data['sizes'] as $size => $path)
        <input type="hidden" name="{{ $name }}{{ $aig }}[sizes][{{ $size }}]" value="{{ $path }}">
    @endforeach
         
    @if ($attributes)
    <div class="popover bottom tb-img-popover hidden" style="left: 50%;transform: translate(-50%, 0%);top: 70px; cursor: auto; min-width: 276px; display: block;"> 
        <div class="arrow"></div>
        
        <div>
            <h3 class="popover-title" style="padding: 4px 10px;">Атрибуты изображения</h3>
        </div>   
            
        <div class="popover-content" style="word-wrap: break-word; padding: 4px;">
            
            <div class="imgtabs">
                <ul style="min-height: 0px;">
                @foreach ($attributes as $tabIdent => $attribute)
                    <li>
                        <a href="#imgtabs-{{ $name }}-{{ $tabIdent }}">{{ $attribute['caption'] }}</a>
                    </li>
                @endforeach
                </ul>
                
                @foreach ($attributes as $tabIdent => $attribute)
                    <div id="imgtabs-{{ $name }}-{{ $tabIdent }}">
                        <table style="border-collapse: separate; border-spacing: 4px 6px; width: 100%;">
                            <tbody>
                                @foreach ($attribute['inputs'] as $inputIdent => $input)
                                <tr>
                                    <td>{{ $input['caption'] }}</td>
                                    <td>
                                        <input type="{{ $input['type'] }}" style="width: 100%;" class="tb-img-attributes-inputs" 
                                               name="{{ $name }}{{ $aig }}[info][{{ $tabIdent }}][{{ $inputIdent }}]"
                                               value="{{ $data['info'][$tabIdent][$inputIdent] or '' }}" >
                                   </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div> 
    
        <script>
            $('.imgtabs').tabs();
        
            $('html').click(function() {
                $('.tb-img-popover').not('.super-img-popover-hack-class').addClass('hidden');
            });
            
            $('.tb-img-popover').click(function(event){
                event.stopPropagation();
            });
        </script>
    
    @endif
    
</div> 