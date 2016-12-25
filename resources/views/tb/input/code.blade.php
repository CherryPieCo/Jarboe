
<?php $rand = rand(111111, 99999999); ?>
<pre>
<code id="{{ $rand }}" class="{{ $language }}">{{ $value }}</code>
</pre>

<script>
    $(document).ready(function() {
        $('#{{ $rand }}').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
