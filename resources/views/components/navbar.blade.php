<div class="bg-gray-800 text-white p-5">
    <div class="flex justify-between items-center px-10 mx-auto">
        <a href="{{ route('home') }}">
            <div class='font-bold text-lg'>Announcement Board App</div>
        </a>
        <div class="flex items-center gap-5">
            @if (isset($user->name))
                <a href="{{ route('profile.show', $user->id) }}">
                    <div>{{ $user->name }}
                        @if (isset($user->role))
                            @include('components.user-role-pill')
                        @endif
                    </div>
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a :href="route('logout')" :href="route('logout')">
                    <button class="bg-gray-500 py-1 px-4 rounded-md"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">{{ __('Log out') }}</button>
                </a>
            </form>
        </div>
    </div>
</div>
