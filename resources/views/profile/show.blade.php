@extends('layouts.main')

@section('content')
<div class='text-3xl font-bold mb-5'>Profile page</div>
<div>User ID: {{$user->id}}</div>
<div>Username: {{$user->name}}</div>
<div>Role: {{$user->role}}</div>
<div>Email: {{$user->email}}</div>

@if ($in_org == null && $owns_org == null)
<div>Member of an organisation: No</div>
@else
<div>Member of an organisation: Yes</div>
@endif

@if ($owns_org == null)
<div>The owner of the organisation: No</div>
@else
<div>The owner of the organisation:: Yes</div>
@endif

@if ($org_data == null)
<div>Organisation: None</div>
@else
<div>Organisation: {{$org_data->name}}</div>


@endif


<div class='text-3xl font-bold my-5'>Announcements</div>

@include('layouts.announcements', ['empty_message'=> 'The user has not shared any announcements'])

@endsection