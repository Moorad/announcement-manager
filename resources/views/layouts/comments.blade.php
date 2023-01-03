<div class=' mx-auto w-full max-w-[40rem] flex flex-col gap-5 my-5'>
    @if (count($comments) == 0)
        <div class="text-center text-gray-400">There are no comments yet</div>
    @endif

    @foreach ($comments as $comment)
        @include('layouts.comment', ['comment' => $comment])
    @endforeach
</div>
