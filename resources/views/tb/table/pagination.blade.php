
<div class="row tb-pagination">
    <div class="col-sm-4">
        <div class="tb-pagination-info">
            Showed: {{ $rows->isEmpty() ? 0 : $rows->firstItem() }} to {{ $rows->lastItem() }} <br>
            Total: {{ $rows->total() }}
        </div>
    </div>
    <div class="col-sm-8 text-right">
        <div class="dataTables_paginate paging_bootstrap_full">
            {!! $rows->appends(request()->all())->render() !!}
             
            @if (is_array($def->getDatabaseOption('paginate')))
                <br><br><br>
                <span>Per page:</span> 
                <div class="btn-group">
                    <?php $first = $per_page ? false : true; ?>
                    @foreach ($def->getDatabaseOption('paginate') as $amount => $caption)
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

