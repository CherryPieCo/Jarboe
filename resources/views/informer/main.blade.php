<!-- Note: The activity badge color changes when clicked and resets the number to 0
Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
<span id="activity" class="activity-dropdown"> 
    <i class="fa fa-info"></i> 
    <b class="badge"> 
        <span class="e-notification-total">{{$total}}</span> 
    </b> 
</span>

<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
<div class="ajax-dropdown">

    <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
    <div class="btn-group btn-group-justified" data-toggle="buttons">
        @foreach ($tabs as $key => $tab)
        <label class="btn btn-default" onclick="TBInformer.fetchNotification('{{$key}}');">
            <input type="radio" name="activity">
            {{ $tab['caption'] }} (<span class="e-notification-count">{{$tab['info']['count']}}</span>)
         </label>
        @endforeach
    </div>

    <!-- notification content -->
    <div class="ajax-notifications custom-scroll">

        <div class="alert alert-transparent">
            <h4>Выберите вкладку для получения информации</h4>
            Это пустое сообщение служит для защиты Вашей конфиденциальности.
        </div>

        <i class="fa fa-lock fa-4x fa-border"></i>

    </div>
    <!-- end notification content -->
    
    <div id="default-lock-message" style="display:none;">
        <div class="alert alert-transparent">
            <h4>Выберите вкладку для получения информации</h4>
            Это пустое сообщение служит для защиты Вашей конфиденциальности.
        </div>
        <i class="fa fa-lock fa-4x fa-border"></i>
    </div>

    <!-- footer: refresh area -->
    <span> информер не обновляется пока открыт
        {{--Last updated on: 12/12/2013 9:43AM
        <button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
            <i class="fa fa-refresh"></i>
        </button> --}}</span>
    <!-- end footer -->

</div>
<!-- END AJAX-DROPDOWN -->

<script src="{{ asset('/packages/yaro/jarboe/tb-informer.js') }}"></script>
<script>
    TBInformer.admin_prefix = '{{ \Config::get('jarboe::admin.uri') }}';
    TBInformer.period = '{{ \Config::get('jarboe::informer.period') }}';
</script>
