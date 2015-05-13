
<div class="row">


<table class="j-files-table table table-bordered table-striped">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th>Название</th>
            <th width="1%">Файл</th>
            <th width="1%"></th>
            <th width="1%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($files as $file)
            @include('admin::tb.storage.file.file_row')
        @endforeach
    </tbody>
</table>
    

</div>
