@extends('layouts.main')

@section('content')
    <div class='flex justify-around text-center'>
        <div>
            <div class='text-sm '>Organisation Name:</div>
            <div class='text-2xl font-bold'>{{ $org_data->name }}</div>
        </div>

        <div>
            <div class='text-sm '>Number of members: </div>
            <div class='text-2xl font-bold'><span id='member_count_top'>{{ $member_count }}</span> members</div>
        </div>

        <div>
            <div class='text-sm '>Org ID: </div>
            <div class='text-2xl font-bold'>{{ $org_data->id }}</div>
        </div>
    </div>

    <div>
        <div class="flex flex-col gap-10">
            <form id='search-form'>
                <div class="flex gap-5">
                    <div class='flex-grow'>
                        <x-input-label for="search" :value="__('Search for user')" />
                        <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" required
                            autofocus />
                    </div>
                    <div class="flex items-end">
                        <button class="bg-blue-500 text-white h-10 px-4 rounded md" type="submit"
                            onclick="event.preventDefault(); searchUsers(this)">
                            Search
                        </button>
                    </div>
            </form>
        </div>

        <div>
            @include('layouts.member_table')
        </div>
        <div id='feedback' class='text-center'></div>

        <div>Number of people selected: <span id='member_count_bottom'>{{ $member_count }}</span></div>


        <div>
            <button>Back</button>
        </div>
    </div>
    </div>

    <script>
        const orgId = '<?php echo $org_data->id; ?>'
        const memberCountBot = document.querySelector('#member_count_bottom');
        const memberCountTop = document.querySelector('#member_count_top');

        function searchUsers(element) {
            const searchInputBox = document.querySelector('#search');
            const memberTable = document.querySelector('#member-table');
            const searchForm = document.querySelector('#search-form');

            const form = new FormData(searchForm);
            form.append('org_id', orgId);
            const data = new URLSearchParams(form);
            fetch('<?php echo route('user.search'); ?>', {
                    method: 'POST',
                    body: data
                }).then(res => res.text())
                .then(html => {
                    memberTable.innerHTML = html;
                })
        }

        function updateMember(element) {
            const isMemberChecked = element.checked;
            const announcerCheckbox = element.parentElement.nextElementSibling.firstElementChild;
            const userId = element.parentElement.parentElement.firstElementChild.innerText

            if (isMemberChecked) {

                console.log(orgId, userId);
                fetchUpdateMember(userId, orgId);
                announcerCheckbox.disabled = false;
                memberCountBot.innerText = Number(memberCountBot.innerText) + 1;
                memberCountTop.innerText = Number(memberCountTop.innerText) + 1
            } else {
                fetchUpdateMember(userId, orgId);
                announcerCheckbox.disabled = true;
                announcerCheckbox.checked = false;
                memberCountBot.innerText = Number(memberCountBot.innerText) - 1;
                memberCountTop.innerText = Number(memberCountTop.innerText) - 1
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
