@extends('admin::layouts.default')

@section('headline')
@stop

@section('scripts')
<script src="{{asset('packages/yaro/jarboe/tb-user.js')}}"></script>
<script>
    TBUser.admin_uri = '{{\Config::get('jarboe::admin.uri')}}';
</script>
@stop

@section('main')
<div id="content">
    <div class="row">
        <!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row" style="padding-right: 13px; padding-left: 13px;">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0px; padding-left: 0px;">

            <div id="table-preloader" class="smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" 
                data-widget-editbutton="false"
                data-widget-colorbutton="false"
                data-widget-deletebutton="false"
                data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Управление пользователями</h2>

                </header>

                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                    </div>
                    <div class="widget-body no-padding">

<form id="e-users-form" 
      action="" 
      method="post" 
      class="form-horizontal tb-table"
      target="submiter" >

<table id="datatable_fixed_column" class="table table-bordered table-striped table-hover smart-form dataTable">

    
    <thead>
        <tr>
        @foreach ($fields as $ident => $field)
            <th>{{ $field['caption'] }}</th>
        @endforeach
            <th class="e-insert_button-cell">
                <a href="{{ url(\Config::get('jarboe::admin.uri') .'/tb/users/create') }}">
                <button class="btn btn-default btn-sm" style="min-width: 66px;" 
                        type="button" onclick="TableBuilder.getCreateForm();">
                    Добавить
                </button>
                </a>
            </th>
        </tr>
    </thead>

    <tbody>
        
        @foreach ($users as $user)
        <tr>
            @foreach ($fields as $ident => $field)
                @if ($ident == 'password')
                    <td>********</td>
                @elseif ($ident == 'id')
                    <td style="width: 1%;">{{ $user->$ident }}</td>
                @else
                    <td>{{ $user->$ident }}</td>
                @endif
            @endforeach
            
            <td style="width: 1%;">
                <a href="{{ url(\Config::get('jarboe::admin.uri') .'/tb/users/'. $user->id) }}">
                    <button type="button" class="btn btn-default btn-sm" rel="tooltip" title="" data-placement="bottom" data-original-title="Update">
                        <i class="fa fa-pencil"></i>
                    </button>
                </a>
                <button onclick="TBUser.doRemoveUser(this, '{{$user->id}}');" type="button" class="btn btn-default btn-sm" rel="tooltip" title="" data-placement="bottom" data-original-title="Remove">
                    <i class="fa fa-remove"></i>
                </button>
            </td>
            
        </tr>
        @endforeach
    </tbody>

</table> 


</form> 
    
    </div>
</div>
@stop
