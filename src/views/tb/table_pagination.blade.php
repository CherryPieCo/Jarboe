
<div class="row tb-pagination">
    <div class="col-sm-4">
        <div class="tb-pagination-info">
            Показано: {{$rows->getFrom()}} по {{$rows->getTo()}} <br>
            Всего: {{$rows->getTotal()}}
        </div>
    </div>
    <div class="col-sm-8 text-right">
        <div class="dataTables_paginate paging_bootstrap_full">
            {{$rows->appends(Input::all())->links()}}
            
            @if (is_array($def['db']['pagination']['per_page']))
                @include('admin::tb.pagination_show_amount')
            @endif
        </div>
    </div>
</div>


{{--
    
<div class="tb-pagination">
    <div class="tb-pagination-inner fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
        {{ $rows->links() }}
    </div>
</div>
    

<!--
<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">
    <a tabindex="0" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default ui-state-disabled">First</a>
    <a tabindex="0" class="previous fg-button ui-button ui-state-default ui-state-disabled">Previous</a>
    <span>
        <a tabindex="0" class="fg-button ui-button ui-state-default ui-state-disabled">1</a>
        <a tabindex="0" class="fg-button ui-button ui-state-default">2</a>
        <a tabindex="0" class="fg-button ui-button ui-state-default">3</a>
        <a tabindex="0" class="fg-button ui-button ui-state-default">4</a>
        <a tabindex="0" class="fg-button ui-button ui-state-default">5</a>
    </span>
    <a tabindex="0" class="next fg-button ui-button ui-state-default">Next</a>
    <a tabindex="0" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default">Last</a>
</div>
</div>
-->

--}}