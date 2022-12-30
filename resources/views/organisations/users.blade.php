@extends('layouts.main')

@section('content')
<div class='flex justify-around text-center'>
	<div>
		<div class='text-sm '>Organisation Name:</div>
		<div class='text-2xl font-bold' >{{$org_data->name}}</div>
	</div>
	
	<div>
		<div class='text-sm '>Number of members: </div>
		<div class='text-2xl font-bold' >0 members</div>
	</div>

	<div>
		<div class='text-sm '>Org ID: </div>
		<div class='text-2xl font-bold' >{{$org_data->id}}</div>
	</div>
</div>

<div>
	<div class="flex flex-col gap-10">
	<form id='search-form'>
		<div class="flex gap-5">
			<div class='flex-grow'>
				<x-input-label for="search" :value="__('Search for user')" />
				<x-text-input id="search" class="block mt-1 w-full" type="text" name="search" required autofocus />
			</div>
			<div class="flex items-end">
				<button class="bg-blue-500 text-white h-10 px-4 rounded md" type="submit" onclick="event.preventDefault(); searchUsers(this)">
					Search
				</button>
			</div>
		</form>
		</div>
	
		<div>
				@include('layouts.member_table')
			</div>

			<div>Number of people selected: <span id='members_selected'>0</span></div>
			
			<div>
				<button>Back</button>
			</div>
	</div>
</div>

<script>
	function enableAnnouncer(element) {
		const isMemberChecked = element.checked;
		const announcerCheckbox = element.parentElement.nextElementSibling.firstElementChild;
		const members_selected = document.querySelector('#members_selected');

		if (isMemberChecked) {
			announcerCheckbox.disabled = false;
			members_selected.innerText = Number(members_selected.innerText) + 1;
		} else {
			announcerCheckbox.disabled = true;
			announcerCheckbox.checked = false;
			members_selected.innerText = Number(members_selected.innerText) - 1;
		}
		
	}

	function searchUsers(element) {
		const searchInputBox = document.querySelector('#search');
		const memberTable = document.querySelector('#member-table');
		const searchForm = document.querySelector('#search-form');

		const data = new URLSearchParams(new FormData(searchForm));
		fetch('<?php echo route("user.search") ?>', {
			method: 'POST',
			body: data
		}).then(res => res.text())
		.then(html => {
			memberTable.innerHTML = html;
		})
	}

	function updateMember(element) {
		enableAnnouncer(element);
		console.log('Updated member')
	}

	function updateAnnouncer(element) {
		console.log('Updated announcer');
	}
</script>
	
	@endsection