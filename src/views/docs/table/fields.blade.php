
<style>
    div.tab-content.min-500 {
        min-height: 625px;
    }
    div.tabs-left>.tab-content {
        margin-left: 139px;
    }
    div.tab-pane.active>p {
        padding-top: 11px;
    }
    ul.nav.p-abs {
        position: absolute;
    }
</style>

<div class="tabs-left">
    <ul class="nav nav-tabs tabs-left p-abs">
        <li class="active">
            <a href="#f-text" data-toggle="tab"> Общее и text </a>
        </li>
        <li>
            <a href="#f-readonly" data-toggle="tab"> readonly </a>
        </li>
        <li>
            <a href="#f-textarea" data-toggle="tab"> textarea </a>
        </li>
        <li>
            <a href="#f-select" data-toggle="tab"> select </a>
        </li>
        <li>
            <a href="#f-checkbox" data-toggle="tab"> checkbox </a>
        </li>
        <li>
            <a href="#f-wysiwyg" data-toggle="tab"> wysiwyg </a>
        </li>
        <li>
            <a href="#f-datetime" data-toggle="tab"> datetime </a>
        </li>
        <li>
            <a href="#f-timestamp" data-toggle="tab"> timestamp </a>
        </li>
        <li>
            <a href="#f-image" data-toggle="tab"> image </a>
        </li>
        <li>
            <a href="#f-image-storage" data-toggle="tab"> image storage </a>
        </li>
        <li>
            <a href="#f-file" data-toggle="tab"> file </a>
        </li>
        <li>
            <a href="#f-foreign" data-toggle="tab"> foreign key </a>
        </li>
        <li>
            <a href="#f-many2many" data-toggle="tab"> many2many </a>
        </li>
        <li>
            <a href="#f-color" data-toggle="tab"> color </a>
        </li>
        <li>
            <a href="#f-custom" data-toggle="tab"> custom </a>
        </li>
        <li>
            <a href="#f-pattern" data-toggle="tab"> паттерн </a>
        </li>
    </ul>
    <div class="tab-content min-500">
        
        <div class="tab-pane active" id="f-text">
            @include('admin::docs.table.fields.common_text')            
        </div>
        
        <div class="tab-pane" id="f-readonly">
            @include('admin::docs.table.fields.readonly')
        </div>        
        
        <div class="tab-pane" id="f-textarea">
            @include('admin::docs.table.fields.textarea')
        </div>
        
        <div class="tab-pane" id="f-select">
            @include('admin::docs.table.fields.select')
        </div>
        
        <div class="tab-pane" id="f-checkbox">
            @include('admin::docs.table.fields.checkbox')
        </div>
        
        <div class="tab-pane" id="f-wysiwyg">
            @include('admin::docs.table.fields.wysiwyg')
        </div>
        
        <div class="tab-pane" id="f-datetime">
            @include('admin::docs.table.fields.datetime')
        </div>   
        
        <div class="tab-pane" id="f-timestamp">
            @include('admin::docs.table.fields.timestamp')
        </div>        
        
        <div class="tab-pane" id="f-image">
            @include('admin::docs.table.fields.image')    
        </div>       
        
        <div class="tab-pane" id="f-image-storage">
            @include('admin::docs.table.fields.image_storage')    
        </div>  
            
        <div class="tab-pane" id="f-file">
            @include('admin::docs.table.fields.file')    
        </div>       
        
        <div class="tab-pane" id="f-foreign">
            @include('admin::docs.table.fields.foreign')    
        </div>    
        
        <div class="tab-pane" id="f-many2many">
            @include('admin::docs.table.fields.many2many')    
        </div>   
        
        <div class="tab-pane" id="f-color">
            @include('admin::docs.table.fields.color')    
        </div>   
        
        <div class="tab-pane" id="f-custom">
            @include('admin::docs.table.fields.custom')    
        </div>  
        
        <div class="tab-pane" id="f-pattern">
            @include('admin::docs.table.fields.pattern')    
        </div>    
        
    </div>
</div>