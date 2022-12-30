<table class='table-auto w-full text-center' id='member-table'>
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
			@if ($user->org_id == null)
				<input type="checkbox" name="" id={{"member-select-" . $index}} onchange="updateMember(this)" >
				@else
				<input type="checkbox" name="" id={{"member-select-" . $index}} onchange="updateMember(this)" checked>
			@endif
		</td>
		<td>
			@if ($user->role == 'announcer')
			<input type="checkbox" name="" id={{"announcer-select-" . $index}} onchange="updateAnnouncer(this)" checked>
			@else
				@if ($user->org_id == null)
				<input type="checkbox" name="" id={{"announcer-select-" . $index}} onchange="updateAnnouncer(this)" disabled>

				@else
				<input type="checkbox" name="" id={{"announcer-select-" . $index}} onchange="updateAnnouncer(this)">

				@endif
			@endif	
			
		</td>
	</tr>
	@endforeach
</tbody>
</table>