@extends('layouts.main')

@section('content')
<div class='text-xl font-bold'>Organisation Name:</div>
<div class='font-medium'>{{$org_data->name}}</div>

<div class='text-xl font-bold'>Number of members: </div>
<div>0</div>

{{-- <div>
	<form action="" class="flex flex-col gap-10">

		<div>
			<x-input-label for="user" :value="__('Organisation name')" />
			<x-text-input id="user" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
		</div>

		<div class="flex gap-5">
			<div class='flex-grow'>
				<x-input-label for="user" :value="__('Search for user')" />
				<x-text-input id="user" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
			</div>

			<div class="flex items-end">
				<button class="bg-blue-500 text-white h-10 px-4 rounded md">
					Search
				</button>
			</div>
		</div>
	
		<div>
			<table class='table-auto w-full text-center'>
				<thead class="border-b bg-gray-100">
					<tr>
						<td>User ID</td>
						<td>Name</td>
						<td>Email</td>
						<td>Role</td>
						<td>Member</td>
						<td>Announcer</td>
					</tr>
				</thead>
					<tbody>
						@foreach ($users as $index=>$user)
						<tr class="border-b">
							<td>{{$user->id}}</td>
							<td>{{$user->name}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->role}}</td>
							<td>
								<input type="checkbox" name="" id={{"member-select-" . $index}} onchange="enableAnnouncer(this)">
							</td>
							<td>
								<input type="checkbox" name="" id={{"announcer-select-" . $index}} disabled>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div>Number of people selected: <span id='members_selected'>0</span></div>
			
			<div>
				<button>Back</button>
			</div>
		</form>
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
	</script> --}}
	
	@endsection