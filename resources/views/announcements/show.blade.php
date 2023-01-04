@extends('layouts.main')

@section('content')
    @if (session()->has('success'))
        <div class="mb-4">
            @include('components.alert', [
                'content' => session()->get('success'),
                'variant' => 'success',
            ])
        </div>
    @endif
    <div class='flex flex-col items-center gap-5'>
        @include('layouts.announcement')

        <div class="w-full">
            <form action="{{ route('comments.store') }}" method="POST" id='comment-form'>
                @csrf

                @method('POST')

                <div class='mx-auto w-full max-w-[40rem]'>
                    <x-input-label for="content" :value="__('Leave a comment')" />
                    <textarea name="content" id="content"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-28 resize-none"></textarea>
                    <div class='flex justify-end'><button class='bg-blue-500 text-white px-5 py-2 rounded-md'
                            onclick="event.preventDefault();submitComment(this)">Send</button></div>
                </div>
            </form>
            <div id='comment-group'>
                @include('layouts.comments')
            </div>
        </div>

    </div>

    <script>
        function submitComment(element) {
            const form = document.querySelector('#comment-form');
            const formData = new FormData(form);
            formData.append('user_id', '<?php echo $user->id; ?>');
            formData.append('announcement_id', '<?php echo $announcement->id; ?>');

            const data = new URLSearchParams(formData);
            fetch('<?php echo route('comments.store'); ?>', {
                    method: 'POST',
                    body: data
                })
                .then(res => res.text())
                .then(html => {
                    document.querySelector('#comment-group').innerHTML = html;
                    const commentCount = document.querySelector('.comment-count');
                    commentCount.innerText = Number(commentCount.innerText) + 1;
                    document.querySelector('#content').value = '';
                });
        }
    </script>
@endsection
