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