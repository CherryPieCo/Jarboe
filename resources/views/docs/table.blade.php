<div class="well well-sm">
<h3 class="text-primary">Построение таблиц и смачные ништяки:</h3>
                    

<ul class="nav nav-tabs bordered">
    <li>
        <a href="#structure" data-toggle="tab">Структура</a>
    </li>
    <li>
        <a href="#fields" data-toggle="tab">Поля</a>
    </li>
    <li>
        <a href="#callbacks" data-toggle="tab">Коллбеки</a>
    </li>
    <li>
        <a href="#traits" data-toggle="tab">Трейты</a>
    </li>
    <li>
        <a href="#helpers" data-toggle="tab">Хелперы</a>
    </li>
    <li class="active pull-right">
        <a href="#common" data-toggle="tab">Quick Start</a>
    </li>
    <li class="pull-right">
        <a href="#mmmm" data-toggle="tab">Ништяки</a>
    </li>
</ul>

<div class="tab-content padding-10">
    <div class="tab-pane" id="structure">
        <div class="table-responsive">
            @include('admin::docs.table.structure')
        </div>
    </div>
    <div class="tab-pane" id="fields">
        <div class="table-responsive">
            @include('admin::docs.table.fields')
        </div>
    </div>
    <div class="tab-pane" id="callbacks">
        <div class="table-responsive">
            @include('admin::docs.callbacks.common')
        </div>
    </div>
    <div class="tab-pane" id="traits">
        <div class="table-responsive">
            @include('admin::docs.traits.common')
        </div>
    </div>
    <div class="tab-pane" id="helpers">
        <div class="table-responsive">
            @include('admin::docs.helpers.common')
        </div>
    </div>
    <div class="tab-pane active" id="common">
        @include('admin::docs.table.quick_start')
    </div>
    <div class="tab-pane " id="mmmm">
        @include('admin::docs.faq.common')
    </div>
</div>






</div>
