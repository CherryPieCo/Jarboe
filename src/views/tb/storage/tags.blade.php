
<div class="row">


<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="text-align: right;"><input style="width:30%;" type="text" name="title" /></th>
            <th width="1%">
                <a href="javascript:void(0);" class="btn btn-default btn-sm" 
                   onclick="Superbox.addTag(this);">
                    <i class="fa fa-times"></i>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tags as $tag)
            <tr>
                <td>{{ $tag->title }}</td>
                <td width="1%">
                    <a href="javascript:void(0);" class="btn btn-default btn-sm" 
                       onclick="Superbox.deleteTag({{ $tag->id }}, this);">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    

</div>
