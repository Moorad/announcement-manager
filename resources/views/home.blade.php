@extends('layouts.main')

@section('content')
    <div class='flex justify-center gap-3'>
        @if ($user->role == 'admin')
            <a href="{{ route('organisations.index') }}">
                <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>View All Organisation</button>
            </a>

            @if ($owns_org == true)
                <a href="{{ route('organisations.show', $org_data->id) }}">
                    <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Manage Organisation Users</button>
                </a>
            @else
                <a href="{{ route('organisations.create') }}">
                    <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Organisation</button>
                </a>
            @endif
        @endif

        @if ($user->role == 'announcer' || $user->role == 'admin')
            @if ($in_org || $owns_org)
                <a href="{{ route('announcements.create') }}">
                    <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Announcement</button>
                </a>
            @else
                <button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'
                    title="You must be part of an organisation first." disabled>Create Announcement</button>
            @endif
        @endif
    </div>
    @if (session()->has('success'))
        <div class="mb-4">
            @include('components.alert', [
                'content' => session()->get('success'),
                'variant' => 'success',
            ])
        </div>
    @elseif ($in_org == true || $owns_org == true)
        @include('components.alert', [
            'content' => "You are a member of the organisation titled <span class='font-bold'>$org_data->name</span>.",
            'variant' => 'info',
        ])
    @elseif ($user->role != 'admin')
        @include('components.alert', [
            'content' =>
                'You are not a part of an organisation, please contact an admin to invite you to an organisation',
            'variant' => 'warning',
        ])
    @elseif ($org_data == null)
        @include('components.alert', [
            'content' =>
                "You do not own an organisation. Click on <span class='font-bold'> Create Organisation </span> to get started.",
        ])
    @else
        Yes org
    @endif

    @include('layouts.announcements', [
        'empty_message' => 'No announcements shared in this organisation yet.',
    ])
@endsection
