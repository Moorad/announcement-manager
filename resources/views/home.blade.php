@extends('layouts.main')

@section('content')

@if ($role == 'admin')
<div class='flex justify-center gap-3'>
	<a href="{{route('organisations.index')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>View All Organisation</button>
	</a>

	@if ($has_org == True)
	<a href="{{route('organisations.users')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Manage Organisation Users</button>
	</a>
	@else
	<a href="{{route('organisations.create')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Organisation</button>
	</a>
	@endif

	<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' title="You must create an organisation first." disabled>Create Post</button>
</div>
@endif

@endsection