@isset($gifs)
    <div class="flex justify-evenly gap-2 flex-wrap">
        @foreach ($gifs as $gif)
            <img src="{{ $gif->images->original->url }}" data-id="{{ $gif->id }}"
                class="h-24 cursor-pointer hover:outline hover:outline-3 hover:outline-blue-500" onclick="selectGif(this);">
        @endforeach
    </div>

    @if (count($gifs) == 0)
        No results
    @endif
@else
    Empty
@endisset
