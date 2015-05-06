@extends('admin::layouts.default')


@section('main')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
        
            {{ $table }}

        </div>
    </div>
    <!-- END MAIN CONTENT -->


@stop

@section('table_form')
    {{ $form }}
@stop