
<div class="tabs-left">
    <ul class="nav nav-tabs tabs-left p-abs">
        <li class="active">
            <a href="#h-settings" data-toggle="tab"> Settings </a>
        </li>
        <li>
            <a href="#h-urlify" data-toggle="tab"> URLify </a>
        </li>
        <li>
            <a href="#h-translate" data-toggle="tab"> Translate </a>
        </li>
        <li>
            <a href="#h-geo" data-toggle="tab"> Geo </a>
        </li>
        <li>
            <a href="#h-helpers" data-toggle="tab"> helpers </a>
        </li>
    </ul>
    <div class="tab-content min-500">
        
        <div class="tab-pane active" id="h-settings">
            @include('admin::docs.helpers.settings')            
        </div>
        
        <div class="tab-pane " id="h-urlify">
            @include('admin::docs.helpers.urlify')      
        </div>
        
        <div class="tab-pane " id="h-translate">
            @include('admin::docs.helpers.translate')      
        </div>
        
        <div class="tab-pane " id="h-geo">
            @include('admin::docs.helpers.geo')      
        </div>
        
        <div class="tab-pane " id="h-helpers">
            @include('admin::docs.helpers.helpers')      
        </div>
        
        
        
    </div>
</div>