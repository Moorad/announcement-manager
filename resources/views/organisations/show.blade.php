@extends('layouts.main')

@section('content')
    <div class='flex justify-around text-center'>
        <div>
            <div class='text-sm '>Organisation Name:</div>
            <div class='text-2xl font-bold'>{{ $org_data->name }}</div>
        </div>

        <div>
            <div class='text-sm '>Number of members: </div>
            <div class='text-2xl font-bold'><span id='member_count'>{{ $member_count }}</span> members</div>
        </div>

        <div>
            <div class='text-sm '>Org ID: </div>
            <div class='text-2xl font-bold'>{{ $org_data->id }}</div>
        </div>
    </div>

    <div>
        <div class="flex flex-col gap-10">
            <form id='search-form' action="{{ route('organisations.show', $org_data->id) }}" method="GET">
                @csrf

                @method('GET')
                <div class="flex gap-5">
                    <div class='flex-grow'>
                        <x-input-label for="search" :value="__('Search for user')" />
                        <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" autofocus />
                    </div>
                    <div class="flex items-end">
                        @include('components.button', [
                            'text' => 'Search',
                        ])
                    </div>
            </form>
        </div>

        <div>
            @include('layouts.member_table')
        </div>
        <div>{{ $users->withQueryString()->links() }}</div>
        <div id='feedback' class='text-center'></div>

        <div>
            <a href="{{ route('home') }}">
                @include('components.button', [
                    'text' => 'Back',
                ])
            </a>
        </div>
    </div>
    </div>

    <script>
        const orgId = '<?php echo $org_data->id; ?>'
        const memberCount = document.querySelector('#member_count');

        function updateMember(element) {
            const isMemberChecked = element.checked;
            const announcerCheckbox = element.parentElement.nextElementSibling.firstElementChild;
            const userId = element.parentElement.parentElement.firstElementChild.innerText

            if (isMemberChecked) {

                console.log(orgId, userId);
                fetchUpdateMember(userId, orgId);
                announcerCheckbox.disabled = false;
                memberCount.innerText = Number(memberCount.innerText) + 1
            } else {
                fetchUpdateMember(userId, orgId);
                announcerCheckbox.disabled = true;
                announcerCheckbox.checked = false;
                memberCount.innerText = Number(memberCount.innerText) - 1
            }
        }

        function updateAnnouncer(element) {
            console.log('Updated announcer');
            const isMemberChecked = element.checked;
            const userId = element.parentElement.parentElement.firstElementChild.innerText

            if (isMemberChecked) {

                console.log(orgId, userId);
                fetchUpdateAnnouncer(userId, orgId);
            } else {
                fetchUpdateAnnouncer(userId, orgId);
            }
        }

        function fetchUpdateMember(userId, orgId) {
            const form = new FormData();
            form.append('user_id', userId);
            form.append('org_id', orgId);
            const data = new URLSearchParams(form);
            fetch('<?php echo route('user.update_member'); ?>', {
                    method: 'POST',
                    body: data
                }).then(res => res.text())
                .then(res => {
                    document.querySelector('#feedback').innerText = res;
                })
        }

        function fetchUpdateAnnouncer(userId, orgId) {
            const form = new FormData();
            form.append('user_id', userId);
            form.append('org_id', orgId);
            const data = new URLSearchParams(form);
            fetch('<?php echo route('user.update_announcer'); ?>', {
                    method: 'POST',
                    body: data
                }).then(res => res.text())
                .then(res => {
                    document.querySelector('#feedback').innerText = res;
                })
        }
    </script>
@endsection
