@extends('layouts.main')

@section('content')

<div class='flex flex-col items-center gap-5'>
		@include('layouts.announcement')

	<div class="w-full">
		<div class='mx-auto w-full max-w-[40rem]'>
		<x-input-label for="org_name" :value="__('Leave a comment')" />
		<textarea name="" id="" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-28 resize-none"></textarea>
		<div class='flex justify-end'><button class='bg-blue-500 text-white px-5 py-2 rounded-md'>Send</button></div>
		</div>
	</div>

	<div>
		<div>ss</div>
	</div>
</div>

@endsection