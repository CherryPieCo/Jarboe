
<div class="row tb-pagination">
    <div class="col-sm-4">
        <div class="tb-pagination-info">
            Показано: {{ $rows->isEmpty() ? 0 : $rows->firstItem() }} по {{ $rows->lastItem() }} <br>
            Всего: {{ $rows->total() }}
        </div>
    </div>
    <div class="col-sm-8 text-right">
        <div class="dataTables_paginate paging_bootstrap_full">
            {!! $rows->appends(Input::all())->render() !!}
            
            @if (is_array($def['db']['pagination']['per_page']))
                <br><br><br>
                <span>Показывать по:</span> 
                <div class="btn-group">
                    <?php $first = $per_page ? false : true; ?>
                    @foreach ($def['db']['pagination']['per_page'] as $amount => $caption)
                    <button type="button" 
                            onclick="TableBuilder.setPerPageAmount('{{$amount}}');" 
                            class="btn btn-default btn-xs @if($amount == $per_page || $first) active @endif">
                        {{$caption}}
                    </button>
                    <?php $first = false; ?>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

