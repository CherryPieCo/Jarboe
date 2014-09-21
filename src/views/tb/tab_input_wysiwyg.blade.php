


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
                    <a href="#{{ $name . $tab['postfix']}}" data-toggle="tab">{{$tab['caption']}}</a>
                </li>
            @endforeach
        </ul>
        
        <div class="tab-content padding-5">
            @foreach ($tabs as $tab)
                @if ($loop->first)
                    <div class="tab-pane active" id="{{ $name . $tab['postfix']}}">
                @else
                    <div class="tab-pane" id="{{ $name . $tab['postfix']}}">
                @endif
                    
                    <div id="{{$name . $tab['postfix']}}-wysiwyg">{{ $tab['value'] }}</div>
                    <textarea id="{{$name . $tab['postfix']}}-inner" name="{{ $name . $tab['postfix'] }}" style="display:none;" class="hidden">{{ $tab['value'] }}</textarea>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                          jQuery('#{{$name . $tab['postfix']}}-wysiwyg').summernote({
                              lang: 'ru-RU',
                              onblur: function(e) {
                                  jQuery('#{{$name . $tab['postfix']}}-inner').html(jQuery('#{{$name . $tab['postfix']}}-wysiwyg').code());
                              },
                              onImageUpload: function(files, editor, $editable) {
                                  TableBuilder.uploadImageFromWysiwygSummertime(files, editor, $editable);
                              },
                              onpaste: function(e) {
                                  var $note = jQuery(this);
                                  
                                  setTimeout(function () {
                                      //this kinda sucks, but if you don't do a setTimeout, 
                                      //the function is called before the text is really pasted.
                                      TableBuilder.doEmbedToText($note);
                                  }, 1);
                              }
                          });
                        });
                    </script>
                    
                    
                </div>
            @endforeach
            
        </div>

    </div>
</section>
