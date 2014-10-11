<br><br><br>
Показать по: 
<div class="btn-group">
    <?php $first = $per_page ? false : true; ?>
    @foreach ($def['db']['pagination']['per_page'] as $amount => $caption)
    <button type="button" 
            onclick="TableBuilder.setPerPageAmount('{{$amount}}');" 
            class="btn btn-default @if($amount == $per_page || $first) btn-info @endif">
        {{$caption}}
    </button>
    <?php $first = false; ?>
    @endforeach
</div>