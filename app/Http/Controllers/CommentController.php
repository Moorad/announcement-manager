<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

		return view('layouts.comments', ['comments' => $comments]);
	}
}
