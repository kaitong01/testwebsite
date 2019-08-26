<div class="module{{ isset($cls) ? $cls: '' }}"{{ isset($id) ? ' id="'.$id.'"': '' }}>

    @if ($title)
    <div class="module-header">{{$title}}</div>
    @endif

    <div class="module-body">{{ $slot }}</div>
</div>
