
<div class="superbox-list">
    <img class="superbox-img" 
         src="{{ glide($image->source, ['w' => 160, 'h' => 160, 'fit' => 'crop']) }}" 
         data-img="{{ glide($image->source, ['w' => 666, 'h' => 420]) }}" 
         data-info="{{ $image->getInfo() }}" 
         data-id="{{ $image->id }}" 
         data-source="{{ asset($image->source) }}" 
         data-createdat="{{ $image->created_at }}"
         title="{{ $image->title }}">
</div>
