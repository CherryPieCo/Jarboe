
<div class="superbox-list">
    <img class="superbox-img" style="width:160px; height: 160px;" 
         src="{{ asset($image->source) }}" 
         data-info="{{ $image->getInfo() }}" 
         data-id="{{ $image->id }}" 
         data-source="{{ asset($image->source) }}" 
         data-createdat="{{ $image->created_at }}"
         title="{{ $image->title }}">
</div>
