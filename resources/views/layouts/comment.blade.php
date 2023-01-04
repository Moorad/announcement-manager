<div class="bg-gray-100 rounded-md">
    <div class=" p-5">
        <a href="{{ route('profile.show', $comment->user_id) }}">
            <div class="font-bold">
                {{ $comment->user_name }} <span
                    class="bg-blue-500 text-white px-2 rounded-full text-sm">{{ $comment->user_role }}</span>
            </div>
        </a>
        <div class="text-sm text-gray-400">{{ $comment->updated_at }}</div>

        <div class="mt-3">{{ $comment->content }}</div>
    </div>
    <div class="flex px-5 pt-2 pb-2 rounded-md justify-between">
        <div class="flex gap-5">
            <div>
                <button onclick="upVoteComment({{ $comment->id }}, this)">Upvote</button>
                <button onclick="downVoteComment({{ $comment->id }}, this)">Downvote</button>
                <span id='vote_value'>{{ $comment->vote_sum ?: 0 }}</span>
            </div>
        </div>
        @if ($user->id == $comment->user_id || $user->role == 'admin')
            <div class="flex gap-5">
                <a href="{{ route('comments.edit', $comment->id) }}">
                    <div class="cursor-pointer">Edit</div>
                </a>
                <form method='POST' action="{{ route('comments.destroy', $comment->id) }}"
                    onsubmit="return confirm('Are you sure you want to delete this?');">
                    @csrf

                    @method('DELETE')
                    <button class="text-red-500 cursor-pointer">Delete</button>
                </form>
            </div>
        @endif
    </div>
</div>
