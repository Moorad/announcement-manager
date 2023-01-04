<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Announcement Board App</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e960eea922.js" crossorigin="anonymous"></script>

    {{-- Custom css used across the app --}}
    <style>
        .default-icon {
            filter: invert(47%) sepia(11%) saturate(478%) hue-rotate(182deg) brightness(91%) contrast(88%);
        }

        .blue-icon {
            filter: invert(71%) sepia(79%) saturate(6093%) hue-rotate(170deg) brightness(105%) contrast(90%);
        }

        .orange-icon {
            filter: invert(46%) sepia(64%) saturate(3888%) hue-rotate(356deg) brightness(93%) contrast(97%);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    @include('layouts.navbar')
    <main class='max-w-[60rem] mx-auto m-5'>
        @yield('content')
    </main>

    <script>
        function upVoteAnnouncement(id, element) {
            fetchVote(id, 1, element);
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
                    // const currentVal = element.parentElement.lastElementChild.innerText;
                    // if (vote > 0) {
                    //     element.firstElementChild.classList.remove('default-icon', 'orange-icon', 'blue-icon');
                    //     if (currentVal < res) {
                    //         console.log('Added up vote')
                    //         element.firstElementChild.classList.add('blue-icon');
                    //     } else {
                    //         console.log('removed up vote')
                    //     }
                    // } else {
                    //     if (currentVal > res) {
                    //         console.log('Added down vote')
                    //     } else {
                    //         console.log('removed down vote')
                    //     }
                    // }

                    element.parentElement.lastElementChild.innerText = res;
                });
        }

        function upVoteComment(id, element) {
            fetchCommentVote(id, 1, element)
        }

        function downVoteComment(id, element) {
            fetchCommentVote(id, -1, element);
        }

        function fetchCommentVote(id, vote, element) {
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
</body>

</html>
