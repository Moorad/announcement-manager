<div class='bg-gray-100 w-full max-w-[40rem] rounded-md'>
    <div class='px-5 py-3'>
        @if ($announcement->priority == 'high')
            <div class="text-red-500 font-bold mb-2">! High priority announcement</div>
        @endif
        <div class='mb-3'>
            <a href="{{ route('profile.show', $announcement->user_id) }}">
                <div class='font-bold'>{{ $announcement->user_name }}
                    @include('components.user-role-pill', ['role' => $announcement->user_role])
                </div>
            </a>
            <div class='text-sm text-gray-400'>{{ $announcement->updated_at }}</div>
        </div>
        <div class='text-2xl font-bold break-words'>{{ $announcement->title }}</div>
        <div class="break-words">{{ $announcement->text }}</div>

        @if ($announcement->attached_image)
            <div>
                <img src="{{ asset('storage/announcement_images/' . $announcement->attached_image) }}" alt=""
                    class='rounded-lg mx-auto w-3/4 my-4'>
            </div>
        @endif
        @isset($tags)
            <div class="flex gap-2 mt-3 mb-1">
                @foreach ($tags as $tag)
                    <div class="bg-blue-500 px-2 rounded-md text-gray-100">{{ $tag->name }}</div>
                @endforeach
            </div>
        @endisset
        @if ($announcement->edited)
            <div class="text-sm text-gray-400 mt-5">Edited on
                {{ $announcement->updated_at }}</div>
        @endif
    </div>
    <div class="flex bg-gray-200 px-5 pt-2 pb-2 rounded-md justify-between">
        <div class="flex gap-10">
            <div class="flex items-center gap-2">
                <button onclick="upVoteAnnouncement({{ $announcement->id }}, this)">
                    <img src="{{ asset('images/up_arrow.svg') }}" class="h-5 w-5 default-icon">
                </button>
                <button onclick="downVoteAnnouncement({{ $announcement->id }}, this)">
                    <img src="{{ asset('images/down_arrow.svg') }}" class="h-5 w-5 default-icon">
                </button>
                <span id='vote_value'>{{ $announcement->vote_sum ?: 0 }}</span>
            </div>
            <a href="{{ route('announcements.show', $announcement->id) }}">
                <div class="flex items-center gap-2 hover:bg-gray-500 hover:bg-opacity-10 px-2 py-1 rounded-md">

                    <i class="fa-solid fa-comment text-lg text-gray-500"></i>
                    @isset($comments)
                        <span class="comment-count">{{ count($comments) ?: 0 }}</span>
                    @else
                        <span class="comment-count">{{ $announcement->comment_count ?: 0 }}</span>
                    @endisset
                </div>
            </a>
        </div>
        @if ($user->id == $announcement->user_id || $user->role == 'admin')
            <div class="flex gap-5">
                <a href="{{ route('announcements.edit', $announcement->id) }}">
                    <div class="cursor-pointer hover:bg-black hover:bg-opacity-10 px-2 py-1 rounded-md"><i
                            class="fa-solid fa-pen"></i> Edit</div>
                </a>
                <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}"
                    onsubmit="return confirm('Are you sure you want to delete this?');">
                    @csrf

                    @method('DELETE')
                    <button
                        class="text-red-500 cursor-pointer hover:bg-red-700 hover:bg-opacity-10 px-2 py-1 rounded-md">
                        <i class="fa-solid fa-trash"></i> Delete</button>
                </form>
            </div>
        @endif
    </div>
</div>
