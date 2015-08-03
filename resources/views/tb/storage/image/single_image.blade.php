
<div class="superbox-list">
    <img class="superbox-img" style="width:160px; height: 160px;" 
         src="{{ asset(cropp($image->getSource())->fit(160, 160)) }}" 
         data-info="{{ $image->getInfo() }}" 
         data-id="{{ $image->id }}" 
         data-source="{{ asset($image->getSource()) }}" 
         data-createdat="{{ $image->created_at }}"
         title="{{ $image->title }}">
</div>
