@extends('layouts.main')

@section('content')

<div class='flex justify-center gap-3'>
	@if ($role == 'admin')
	<a href="{{route('organisations.index')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>View All Organisation</button>
	</a>
	
	@if ($owns_org == True)
	<a href="{{route('organisations.users')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Manage Organisation Users</button>
	</a>
	@else
	<a href="{{route('organisations.create')}}">
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Organisation</button>
	</a>
	@endif
	@endif
	
	@if ($role == 'announcer' || $role == 'admin')
		@if ($in_org || $owns_org)
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Post</button>
		@else
		<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg' title="You must be part of an organisation first." disabled>Create Post</button>
		@endif
	@endif	
</div>


@if ($in_org == True)
	<div class='text-center my-4'>You have been added to <span class='font-bold'>{{$org_data->name}}</span>, you can now interact with the organisation</div>
@elseif ($role != 'admin')
<div class='text-center my-4 text-gray-400'>You are not part of an organisation, please contact an admin to invite you to an organisation</div>
@endif

@endsection