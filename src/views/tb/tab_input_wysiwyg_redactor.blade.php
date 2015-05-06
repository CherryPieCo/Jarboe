
<section>
    <div class="tab-pane active">
                
        <ul class="nav nav-tabs tabs-pull-right">
            <label class="label pull-left" style="line-height: 32px;">{{$caption}}</label>
            @foreach ($tabs as $tab)
                @if ($loop->first)
                    <li class="active">
                @else
                    <li class="">
                @endif
                
                    <a href="#{{$pre .  $name . $tab['postfix']}}" data-toggle="tab">{{$tab['caption']}}</a>
                </li>
            @endforeach
        </ul>
        
        <div class="tab-content padding-5">
            @foreach ($tabs as $tab)
                
                @if ($loop->first)
                    <div class="tab-pane active" id="{{ $pre . $name . $tab['postfix']}}">
                @else
                    <div class="tab-pane" id="{{ $pre . $name . $tab['postfix']}}">
                @endif
                    
                    <textarea id="{{$pre . $name . $tab['postfix']}}-wysiwyg" name="{{ $name . $tab['postfix'] }}">{{ $tab['value'] }}</textarea>
                    
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery('#{{$pre . $name . $tab['postfix']}}-wysiwyg').redactor({
                                buttonSource: true,
                                imageUpload: '{{ url($action) }}?query_type=redactor_image_upload',
                                imageUploadCallback: function(image, json) {
                                    console.log(this);
                                    console.log(image);
                                    console.log(json);
                                    //TableBuilder.uploadImageFromWysiwygSummertime(files, editor, $editable);
                                },
                                <?php // FIXME: ?>
                                imageManagerJson: '{{ url($action) }}?query_type=image_storage&storage_type=get_redactor_images_list&__node={{ \Input::get('__node') }}',
                                plugins: ['imagemanager']
                            });
                        });
                    </script>
                    
                </div>
            @endforeach
            
        </div>

    </div>
</section>


