
<div class="j-images-smoke" style="display:none; height: 100%; width: 100%; position: fixed; z-index: 42;">

    <div style="height: 100%; width: 100%; background-color: #000; position: fixed; opacity: 0.6;"></div>

    <div class="progress progress-sm progress-striped active">
        <div class="j-images-progress-fail progress-bar bg-color-redLight" style="width: 0%"></div>
        <div class="j-images-progress-success progress-bar bg-color-greenLight" style="width: 0%"></div>
    </div>                                              

    <div style="margin: 0 auto; height: 220px; width: 400px; background-color: whitesmoke; position: fixed; margin-right: -200px; right: 50%;">
        
        <h2 style="text-align: center; font-weight: 500;">Процесс загрузки</h2>
        <hr>
        <dl class="dl-horizontal">
          <dt>Успешно</dt>
          <dd><span class="j-images-upload-success">0</span></dd>
          <dt>Неуспешно</dt>
          <dd><span class="j-images-upload-fail">0</span></dd>
          <dt>Загружено / всего</dt>
          <dd><span class="j-images-upload-upload">0</span> / <span class="j-images-upload-total">0</span></dd>
        </dl>
        <hr>
        
        <a href="javascript:void(0);" onclick="$(this).hide().parent().parent().hide();$('.j-images-progress-fail').css('width', '0%');$('.j-images-progress-success').css('width', '0%');" class="btn btn-info j-images-upload-finish-btn" style="display:none; margin-left: 166px;">готово</a>
        
    </div>
    
</div>
