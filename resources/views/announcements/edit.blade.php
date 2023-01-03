@extends('layouts.main')

@section('content')
    <form method="POST" action="{{ route('announcements.update', $announcement->id) }}" class="flex flex-col gap-10"
        enctype="multipart/form-data">
        @csrf

        @method('PUT')
        <div class='flex flex-col gap-5'>
            <div>
                <x-input-label for="announcement_title" :value="__('Announcement Title')" />
                <x-text-input id="announcement_title" class="block mt-1 w-full" type="text" name="announcement_title"
                    required value='{{ $announcement->title }}' autofocus />
            </div>
            <div>
                <x-input-label for="announcement_text" :value="__('Announcement Text')" />
                <textarea id="announcement_text"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-40"
                    type="text" name="announcement_text" required autofocus>{{ $announcement->text }}</textarea>
            </div>

            <div>
                <x-input-label for="announcement_priority" :value="__('Announcement Priority')" />

                @if ($announcement->priority == 'high')
                    <input type="radio" id="high" name="announcement_priority" value="high" checked>
                @else
                    <input type="radio" id="high" name="announcement_priority" value="high">
                @endif
                <label for="high">High</label>
                <div class="text-sm text-gray-400">
                    An email notification will be sent to all members and the announcement will be
                    pinned.
                </div>
                @if ($announcement->priority == 'normal')
                    <input type="radio" id="normal" name="announcement_priority" value="normal" checked>
                @else
                    <input type="radio" id="normal" name="announcement_priority" value="normal">
                @endif
                <label for="normal">Normal</label>
                <div class="text-sm text-gray-400">
                    An email notification will be sent to all members.
                </div>
                @if ($announcement->priority == 'low')
                    <input type="radio" id="low" name="announcement_priority" value="low" checked>
                @else
                    <input type="radio" id="low" name="announcement_priority" value="low">
                @endif
                <label for="low">Low</label>
                <div class="text-sm text-gray-400">
                    No email notification will be sent.
                </div>
            </div>
        </div>
        </div>
        <div class="self-end">
            <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' type='submit'>Submit</button>
        </div>
    </form>
@endsection
