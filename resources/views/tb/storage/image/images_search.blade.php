
<div class="b-j-search well">
<form id="j-images-search-form">
<table class="table table-bordered" style="margin: 0;">
    <thead>
        <tr>
            <th width="35%">Название</th>
            <th width="10%">Создана (от)</th>
            <th width="10%">Создана (до)</th>
            <th width="1%"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div style="position: relative;">
                    <input type="text" value="{{{ Session::get('_jsearch_images.title') }}}" name="_jsearch[title]" class="form-control input-small">
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" value="{{{ Session::get('_jsearch_images.from') }}}" name="_jsearch[created_at][from]" placeholder="Select a date" class="form-control j-datepicker" data-dateformat="dd/mm/yy">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" value="{{{ Session::get('_jsearch_images.to') }}}" name="_jsearch[created_at][to]" placeholder="Select a date" class="form-control j-datepicker" data-dateformat="dd/mm/yy">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </td>
            <td>
                <a onclick="Superbox.searchImages(this);" 
                href="javascript:void(0);" 
                class="btn btn-default btn-sm">Поиск</a>
            </td>
        </tr>
    </tbody>
</table>
</form>
</div>
