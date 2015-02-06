
<?php $ancestors = $current->getAncestorsAndSelf(); ?>
@foreach ($ancestors as $ancestor)

    @if ($ancestor->slug == '/')
        <a href="?node=1">{{ url($ancestor->slug) }}</a> / 
    @elseif ($loop->last)
        {{ $ancestor->slug }}
    @else
        <a href="?node={{ $ancestor->id }}">{{ $ancestor->slug }}</a> / 
    @endif
@endforeach