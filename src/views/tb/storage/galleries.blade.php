
<div class="row">


<table class="j-galleries-table table table-bordered table-striped">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th style="text-align: right;"><input style="width:30%;" type="text" name="title" /></th>
            <th width="1%">
                <a href="javascript:void(0);" class="btn btn-default btn-sm" 
                   onclick="Superbox.addGallery(this);">
                    Добавить
                </a>
            </th>
            @if ($type == 'gallery')
            <th></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($galleries as $gallery)
            @include('admin::tb.storage.gallery_row')
        @endforeach
    </tbody>
</table>
    

</div>
