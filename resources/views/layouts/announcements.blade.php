<div class='flex flex-col justify-center items-center gap-10 mt-6'>
	@foreach ($announcements as $announcement)
	<div class='bg-gray-100 w-full max-w-[40rem] rounded-md'>
			<div class='px-5 py-3'>
				<div class='mb-3'>
					<div class='font-bold'>{{$announcement->user_name}} <span class='bg-blue-500 text-white px-2 rounded-full text-sm'>{{$announcement->user_role}}</span></div>
					<div class='text-sm text-gray-400'>{{$announcement->updated_at}}</div>
				</div>
				<div class='text-2xl font-bold'>{{$announcement->title}}</div>
				<div>{{$announcement->text}}</div>
				<div>Image here</div>
			</div>
			<div class="flex bg-gray-200 px-5 pt-2 pb-2 rounded-md gap-5">
				<div>
					<button>Upvote</button>
				<button>Downvote</button>
				<span>0</span>
				</div>
				<div>
					<button>Comments</button>
					<span>0</span>
				</div>
			</div>
		</div>
	@endforeach
</div>