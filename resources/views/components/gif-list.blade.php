@isset($gifs)
    <div class="flex justify-center gap-2 flex-wrap">
        @foreach ($gifs as $gif)
            <img src="{{ $gif->images->original->url }}" class="h-24">
        @endforeach
    </div>

    @if (count($gifs) == 0)
        No results
    @endif
@else
    Empty
@endisset
