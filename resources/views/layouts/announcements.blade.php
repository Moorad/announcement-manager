<div class='flex flex-col justify-center items-center gap-10 mt-6'>
		@if (count($announcements) == 0)
		<div class='text-gray-400'>{{$empty_message}}</div>
		@endif

		@foreach ($announcements as $announcement)
		<div class='bg-gray-100 w-full max-w-[40rem] rounded-md'>
				<div class='px-5 py-3'>
					<div class='mb-3'>
						<a href="{{route('profile.show', $user_id)}}">
							<div class='font-bold'>{{$announcement->user_name}} <span class='bg-blue-500 text-white px-2 rounded-full text-sm'>{{$announcement->user_role}}</span></div>
						</a>
						<div class='text-sm text-gray-400'>{{$announcement->updated_at}}</div>
					</div>
					<div class='text-2xl font-bold'>{{$announcement->title}}</div>
					<div>{{$announcement->text}}</div>
					
					@if ($announcement->attached_image)
					<div>
						<img src="{{asset('storage/announcement_images/'.$announcement->attached_image)}}" alt="" class='rounded-lg mx-auto w-3/4 my-4'>
					</div>
					@endif

				</div>
				<div class="flex bg-gray-200 px-5 pt-2 pb-2 rounded-md gap-5">
					<div>
						<button onclick="upVote({{$announcement->id}}, this)">Upvote</button>
						<button onclick="downVote({{$announcement->id}}, this)">Downvote</button>
					<span id='vote_value'>{{$announcement->vote_sum ?: 0}}</span>
					</div>
					<div>
						<button>Comments</button>
						<span>0</span>
					</div>
				</div>
			</div>
		@endforeach
	<div id='test'></div>
	<script>

		function upVote(id, element) {
			fetchVote(id, 1, element)
		}

		function downVote(id, element) {
			fetchVote(id, -1, element);
		}

		function fetchVote(id, vote, element) {
			const form = new FormData();
			form.append('announcement_id', id);
			form.append('vote_val', vote);
			form.append('user_id', '<?php echo $user_id ?>')

			const data = new URLSearchParams(form);
			
			fetch("<?php echo route('announcements.vote') ?>", {
				method: 'POST',
				body: data,
			}).then(res => res.text())
			.then((res) => {
				element.parentElement.lastElementChild.innerText = res;
			});
		}

	</script>
</div>