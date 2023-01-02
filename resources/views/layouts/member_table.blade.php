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
        @foreach ($users as $i => $u)
            {{-- {{ $u }} --}}
            <tr class="border-b">
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if ($u->org_id == null)
                        <input type="checkbox" name="" id={{ 'member-select-' . $i }} onchange="updateMember(this)">
                    @else
                        <input type="checkbox" name="" id={{ 'member-select-' . $i }} onchange="updateMember(this)"
                            checked>
                    @endif
                </td>
                <td>
                    @if ($u->role == 'announcer')
                        <input type="checkbox" name="" id={{ 'announcer-select-' . $i }}
                            onchange="updateAnnouncer(this)" checked>
                    @else
                        @if ($u->org_id == null)
                            <input type="checkbox" name="" id={{ 'announcer-select-' . $i }}
                                onchange="updateAnnouncer(this)" disabled>
                        @else
                            <input type="checkbox" name="" id={{ 'announcer-select-' . $i }}
                                onchange="updateAnnouncer(this)">
                        @endif
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
