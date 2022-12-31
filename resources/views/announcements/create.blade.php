@extends('layouts.main')

@section('content')

<form method="POST" action="{{route('announcements.store')}}" class="flex flex-col gap-10" enctype="multipart/form-data">
	@csrf
	
	@method('POST')

	<div class='flex flex-col gap-5'>
		<div>
			<x-input-label for="announcement_title" :value="__('Announcement Title')" />
			<x-text-input id="announcement_title" class="block mt-1 w-full" type="text" name="announcement_title" required autofocus />
		</div>
		<div>
			<x-input-label for="announcement_text" :value="__('Announcement Text')" />
			<textarea id="announcement_text" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-40" type="text" name="announcement_text" required autofocus></textarea>
		</div>

		<div>
			<x-input-label for="announcement_image" :value="__('Attach Images (Optional)')" />
			<input name="announcement_image" type="file" id='announcement_image' accept="image/*" class='mt-1 text-grey-500
            file:mr-5 file:py-2 file:px-4
            file:rounded-md file:border-0
            file:text-base file:font-medium
            file:bg-blue-500 file:text-white
            hover:file:cursor-pointer'/>
			<div class='text-gray-500'>SVG, PNG, JPG, GIF or WebP.</div>
		</div>
	</div>

	<div class="self-end">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' type='submit'>Submit</button>
	</div>
	</form>

@endsection