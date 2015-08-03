
<?php $ancestors = $current->getAncestorsAndSelf(); ?>
@foreach ($ancestors as $ancestor)

    @if ($ancestor->slug == '/' || !$ancestor->slug)
        <a href="?node=1">{{ url($ancestor->slug) }}</a> / 
    @elseif ($loop->last)
        {{ $ancestor->slug }}
    @else
        <a href="?node={{ $ancestor->id }}">{{ $ancestor->slug }}</a> / 
    @endif
@endforeach

<hr style="margin: 3px 0;">

@foreach ($ancestors as $ancestor)
    @if ($ancestor->slug == '/' || !$ancestor->slug)
        <a href="?node=1">{{ $ancestor->title }}</a> / 
    @elseif ($loop->last)
        {{ $ancestor->title }}
    @else
        <a href="?node={{ $ancestor->id }}">{{ $ancestor->title }}</a> / 
    @endif
@endforeach