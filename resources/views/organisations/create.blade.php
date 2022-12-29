@extends('layouts.main')

@section('content')
<div>
	<form method="POST" action="{{ route('organisations.store') }}" class="flex flex-col gap-10">
		@csrf
		
		@method('POST')

		<div>
			<x-input-label for="org_name" :value="__('Organisation name')" />
			<x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name" required autofocus />
		</div>

		<div class="self-end">
			<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' type='submit'>Submit</button>
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
	</script>
	
	@endsection