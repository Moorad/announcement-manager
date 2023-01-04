@extends('layouts.main')

@section('content')
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class='flex flex-col gap-5'>
            <div>
                <x-input-label for="comment_content" :value="__('Comment Text')" />
                <textarea id="comment_content"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-32"
                    type="text" name="comment_content" required autofocus>{{ $comment->content }}</textarea>
            </div>
            <div class="self-end">
                <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' type='submit'>Submit</button>
            </div>
        </div>
    </form>
@endsection
