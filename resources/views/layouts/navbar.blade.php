<div class="bg-gray-800 text-white p-5">
	<div class="flex justify-between items-center px-10 mx-auto">
		<div class='font-bold text-lg'>Announcement Board App</div>
		<div class="flex items-center gap-5">
			@if (isset($name))
			<div><span>Logged in as:</span> {{$name}}
				@if (isset($role))
				<span class='bg-blue-500 px-2 rounded-full'>{{$role}}</span>
				@endif
			</div>
			@endif
			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<a :href="route('logout')" :href="route('logout')">
					<button class="bg-gray-500 py-1 px-4 rounded-md" onclick="event.preventDefault();
                                        this.closest('form').submit();">{{ __('Log out') }}</button>
				</a>
			</form>
		</div>
	</div>
</div>