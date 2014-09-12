@extends('admin::layouts.default')


@section('main')

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            {{ $table }}

            <div id="modal_wrapper"></div>
            
            {{ $form }}
        
        </div>
    
    </div>
    <!-- END MAIN CONTENT -->

@stop