
<div class="superbox-list">
    <img class="superbox-img" 
         src="{{ glide($image->source, ['w' => 160, 'h' => 160, 'fit' => 'crop']) }}" 
         data-img="{{ glide($image->source, ['w' => 666, 'h' => 420]) }}" 
         data-info="{{ $image->getInfo() }}" 
         data-id="{{ $image->id }}" 
         title="{{ $image->title }}">
</div>
