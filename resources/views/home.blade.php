@extends('layouts.main')

@section('content')

@if ($role == 'admin')
<div class='flex justify-center gap-3'>
	<a href="{{route('organisations.index')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>View All Organisation</button>
	</a>

	<a href="{{route('organisations.create')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Organisation</button>
	</a>

	<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' disabled>Create Post</button>
</div>
@endif

@endsection