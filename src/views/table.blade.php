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

<style>
.image_storage_wrapper {
  width: 100%;
  height: 100%;
  z-index: 999901;
  position: fixed;
  top: 0;
  left: 0;
  overflow: auto;
  background: #fff;
}
.image_storage_wrapper .close_image_storage {
  position: fixed;
  top: 3px;
  right: 20px;
  z-index: 9;
}
</style>

@stop