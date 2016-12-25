
<div class="row">


<table class="j-tags-table table table-bordered table-striped">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th style="text-align: right;"><input style="width:30%;" type="text" name="title" /></th>
            <th width="1%">
                <a href="javascript:void(0);" class="btn btn-default btn-sm" 
                   onclick="Superbox.addTag(this);">
                    Добавить
                </a>
            </th>
            @if ($type == 'tag')
            <th></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($tags as $tag)
            @include('admin::tb.storage.image.tag_row')
        @endforeach
    </tbody>
</table>
    

</div>
