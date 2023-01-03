<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\AnnouncementInteraction;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	//

	public function store(Request $request)
	{
		$comment = new Comment;
		$comment->announcement_id = $request->announcement_id;
		$comment->user_id = $request->user_id;
		$comment->content = $request->content;
		$comment->save();

		$comments = Comment::where('announcement_id', $request->announcement_id)
			->join('users', 'users.id', 'comments.user_id')
			->select('comments.*', 'users.name as user_name', 'users.role as user_role')->get();


		$userCommented = User::where('id', $request->user_id)->first();
		$announcement = Announcement::where('id', $request->announcement_id)->first();
		$announcementOwner = User::where('id', $announcement->user_id)->first();

		$announcementOwner->notify(new AnnouncementInteraction(['comment', $announcement, $userCommented]));

		return view('layouts.comments', ['comments' => $comments]);
	}
}
