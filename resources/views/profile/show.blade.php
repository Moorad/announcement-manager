@extends('layouts.main')

@section('content')
    <div class='text-3xl font-bold mb-5'>Profile page</div>
    <div>User ID: {{ $user->id }}</div>
    <div>Username: {{ $user->name }}</div>
    <div>Role: {{ $user->role }}</div>
    <div>Email: {{ $user->email }}</div>

    @if ($in_org == null && $owns_org == null)
        <div>Member of an organisation: No</div>
    @else
        <div>Member of an organisation: Yes</div>
    @endif

    @if ($owns_org == null)
        <div>The owner of the organisation: No</div>
    @else
        <div>The owner of the organisation:: Yes</div>
    @endif

    @if ($org_data == null)
        <div>Organisation: None</div>
    @else
        <div>Organisation: {{ $org_data->name }}</div>
    @endif


    <div class='text-3xl font-bold my-5'>Announcements</div>

    @include('layouts.announcements', ['empty_message' => 'The user has not shared any announcements'])

    <div class='text-3xl font-bold my-5'>Comments</div>

    <div class='mx-auto w-full max-w-[40rem] flex flex-col gap-5 my-5'>
        @foreach ($comments as $comment)
            <div>
                <div>Commented on <a href="{{ route('announcements.show', $comment->announcement_id) }}"
                        class="text-blue-600 underline">{{ $comment->announcement_title }}</a>:</div>
                @include('layouts.comment', ['comment' => $comment])
            </div>
        @endforeach
    </div>
    <script>
        function upVoteComment(id, element) {
            fetchVote(id, 1, element)
        }

        function downVoteComment(id, element) {
            fetchVote(id, -1, element);
        }

        function fetchVote(id, vote, element) {
            const form = new FormData();
            form.append('comment_id', id);
            form.append('vote_val', vote);
            form.append('user_id', '<?php echo $user->id; ?>')

            const data = new URLSearchParams(form);

            fetch("<?php echo route('comments.vote'); ?>", {
                    method: 'POST',
                    body: data,
                }).then(res => res.text())
                .then((res) => {
                    element.parentElement.lastElementChild.innerText = res;
                });
        }
    </script>
@endsection
