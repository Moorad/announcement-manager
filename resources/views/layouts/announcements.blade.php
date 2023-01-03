<div class='flex flex-col justify-center items-center gap-10 mt-6'>
    @if (($in_org != null || $owns_org != null) && count($announcements) == 0)
        <div class='text-gray-400'>{{ $empty_message }}</div>
    @endif

    @foreach ($announcements as $announcement)
        @include('layouts.announcement')
    @endforeach
    <script>
        function upVoteAnnouncement(id, element) {
            fetchVote(id, 1, element)
        }

        function downVoteAnnouncement(id, element) {
            fetchVote(id, -1, element);
        }

        function fetchVote(id, vote, element) {
            const form = new FormData();
            form.append('announcement_id', id);
            form.append('vote_val', vote);
            form.append('user_id', '<?php echo $user->id; ?>')

            const data = new URLSearchParams(form);

            fetch("<?php echo route('announcements.vote'); ?>", {
                    method: 'POST',
                    body: data,
                }).then(res => res.text())
                .then((res) => {
                    element.parentElement.lastElementChild.innerText = res;
                });
        }
    </script>
</div>
