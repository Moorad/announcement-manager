@extends('layouts.main')

@section('content')

<form method="POST" action="{{ route('organisations.store') }}" class="flex flex-col gap-10">
	@csrf
	
	@method('POST')

	<div class='flex flex-col gap-5'>
		<div>
			<x-input-label for="org_name" :value="__('Announcement Title')" />
			<x-text-input id="org_name" class="block mt-1 w-full" type="text" name="announcement_title" required autofocus />
		</div>
		<div>
			<x-input-label for="org_name" :value="__('Announcement Text')" />
			<textarea id="org_name" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-40" type="text" name="announcement_text" required autofocus></textarea>
		</div>

		<div>
			<x-input-label for="org_name" :value="__('Attach Images (Optional)')" />
			<input type="file" class='hidden' id='file_upload'>
			<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg mt-1' onclick="document.querySelector('#file_upload').click()" type="button">Upload Image</button>
		</div>
	</div>

	<div class="self-end">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' type='submit'>Submit</button>
	</div>
	</form>

@endsection