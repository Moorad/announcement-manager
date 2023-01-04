@if (session()->has('comment-success'))
    <div class="mb-4">
        @include('components.alert', [
            'content' => session()->get('comment-success'),
            'variant' => 'success',
        ])
    </div>
@else
    @isset($comment_success)
        @include('components.alert', [
            'content' => $comment_success,
            'variant' => 'success',
        ])
    @endisset
@endif

<div class=' mx-auto w-full max-w-[40rem] flex flex-col gap-5 my-5'>
    @if (count($comments) == 0)
        <div class="text-center text-gray-400">There are no comments yet</div>
    @endif

    @foreach ($comments as $comment)
        @include('layouts.comment', ['comment' => $comment])
    @endforeach
</div>
