@extends('admin::layouts.default')


@section('main')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
        
            {{ $table }}

            {{ $form }}
        
        </div>
    </div>
    <!-- END MAIN CONTENT -->


@stop