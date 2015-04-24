@extends('admin::layouts.default')


@section('main')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
        
            {{ $table }}

            <div id="modal_wrapper"></div>
            
            <div class="image_storage_wrapper" style="display:none;">
                <div class="close_image_storage">
                    <a href="javascript:void(0);" onclick="TableBuilder.closeImageStorageModal();" class="btn btn-info btn-xs"><i class="fa fa-times"></i></a>
                </div>
                <div id="modal_image_storage_wrapper" style="padding: 25px 35px;"></div>
            </div>
            
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