<div class=' mx-auto w-full max-w-[40rem] flex flex-col gap-5 my-5'>
    @if (count($comments) == 0)
        <div class="text-center text-gray-400">There are no comments yet</div>
    @endif

    @foreach ($comments as $comment)
        @include('layouts.comment', ['comment' => $comment])
    @endforeach
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
</div>
