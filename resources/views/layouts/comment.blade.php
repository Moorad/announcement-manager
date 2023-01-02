<div class="bg-gray-100 p-5 rounded-md">
	<a href="{{route('profile.show',$comment->user_id)}}">
		<div class="font-bold">
			{{$comment->user_name}} <span class="bg-blue-500 text-white px-2 rounded-full text-sm">{{$comment->user_role}}</span>
		</div>
	</a>
	<div class="text-sm text-gray-400">{{$comment->updated_at}}</div>

	<div class="mt-3">{{$comment->content}}</div>
</div>