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

    <div class='mx-auto w-full max-w-[40rem] flex flex-col gap-5 my-5' id='comment-group''>
        @foreach ($comments as $comment)
            <div>
                <div>Commented on <a href="{{ route('announcements.show', $comment->announcement_id) }}"
                        class="text-blue-600 underline">{{ $comment->announcement_title }}</a>:</div>
                @include('layouts.comment', ['comment' => $comment])
            </div>
        @endforeach
    </div>
@endsection
