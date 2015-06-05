
<tr class="image-storage-edit-gallery-tr">
<td colspan="6">

    <form class="form-horizontal" style="margin-bottom: 20px;">
                                            
        <fieldset>
            <legend>
                #{{$gallery->id}}: {{$gallery->title}}
                <a onclick="Superbox.closeGalleryContentForm();" style="float: right;" class="btn btn-xs bg-color-blueDark txt-color-white" href="javascript:void(0);">
                    <i class="fa fa-times"></i>
                </a>
            </legend>
            
            @if ($gallery->images->count())
                <ul id="sortable">
                @foreach ($gallery->images as $image)
                    <li class="ui-state-default" id="{{$image->id}}">
                        <img class="j-image-dblclk" src="{{asset(cropp($image->source)->fit(80))}}" style="height: 80px; width: 80px;"/>
                        <a onclick="Superbox.deleteGalleryImageRelation(this, {{$image->id}}, {{$gallery->id}});" style="position: absolute; right: 0; bottom: 0; width: 100%;" 
                            href="javascript:void(0);" 
                            class="btn btn-default btn-xs">Удалить</a>
                    </li>
                @endforeach
                </ul>
            @else
                В галерее нет изображений
            @endif
            
        </fieldset>
        
    </form>
    
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
        #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 90px; height: 110px; font-size: 4em; text-align: center; cursor: all-scroll; }
        .ui-state-highlight { width: 90px; height: 90px; }
    </style>
    <script>
      $(function() {
        $("#sortable").sortable({
            placeholder: "ui-state-highlight",
            items: 'li',
            context: this,
            create: function(event, ui) {
                $('.j-image-dblclk').dblclick(function() {
                    Superbox.showImageFormFromGalleryView(this);
                });
            },
            update: function() {
                var order = $(this).sortable('toArray');
                Superbox.onGalleryImagesPriorityChange({{$gallery->id}}, order);
            } // end update
        });
        $("#sortable").disableSelection();
      });
    </script>

</td>
</tr>

