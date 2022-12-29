@extends('layouts.main')

@section('content')

<div>
		<table class='table-auto w-full text-center'>
			<thead class="border-b bg-gray-100">
				<tr>
					{{-- {{-- <td>User ID</td> --}}
					<td>Org ID</td>
					<td>Org Name</td>
					<td>Admin ID</td>
					<td>Admin Name</td>
				</tr>
			</thead>
				<tbody>
					@foreach ($organisations as $organisation)
					<tr class="border-b">
						<td>{{$organisation->id}}</td>
						<td>{{$organisation->name}}</td>
						<td>{{$organisation->admin_id}}</td>
						<td>{{$organisation->admin_name}}</td>

					</tr>
					@endforeach
				</tbody>
			</table>

@endsection