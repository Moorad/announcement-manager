@isset($role)
    @switch($role)
        @case('admin')
            <span class='bg-red-500 px-2 rounded-full text-sm text-white font-bold'>{{ $role }}</span>
        @break

        @case ('announcer')
            <span class='bg-blue-500 px-2 rounded-full text-sm text-white font-bold'>{{ $role }}</span>
        @break

        @default
            <span class='bg-gray-500 px-2 rounded-full text-sm text-white font-bold'>{{ $role }}</span>
    @endswitch
@else
    @switch(auth()->user()->role)
        @case('admin')
            <span class='bg-red-500 px-2 rounded-full text-sm text-white font-bold'>{{ auth()->user()->role }}</span>
        @break

        @case ('announcer')
            <span class='bg-blue-500 px-2 rounded-full text-sm text-white font-bold'>{{ auth()->user()->role }}</span>
        @break

        @default
            <span class='bg-gray-500 px-2 rounded-full text-sm text-white font-bold'>{{ auth()->user()->role }}</span>
    @endswitch
@endisset
