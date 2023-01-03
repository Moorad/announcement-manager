<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use App\Models\User;
use App\Models\Vote;
use App\Notifications\AnnouncementInteraction;
use App\Notifications\CommentInteraction;
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

	public function update_vote(Request $request)
	{
		$userVoteExists = Vote::whereHasMorph('votable', [Comment::class])->where('votable_id', $request->comment_id)
			->where('user_id', $request->user_id);

		$userVoted = User::where('id', $request->user_id)->first();
		$comment = Comment::where('id', $request->comment_id)->first();
		$commentOwner = User::where('id', $comment->user_id)->first();
		$announcement = Announcement::where('id', $comment->announcement_id)->first();

		if ($userVoteExists->first() == null) {
			$vote = new Vote;
			$vote->votable_id = $request->comment_id;
			$vote->votable_type = Comment::class;
			$vote->user_id = $request->user_id;
			$vote->vote_val = $request->vote_val;
			$vote->save();

			if ($request->vote_val > 0) {
				$commentOwner->notify(new CommentInteraction(['upvote', $announcement, $userVoted]));
			} else {
				$commentOwner->notify(new CommentInteraction(['downvote', $announcement, $userVoted]));
			}
		} else {
			if ($userVoteExists->first()->vote_val == $request->vote_val) {
				$userVoteExists->delete();
			} else {
				$userVoteExists->update(['vote_val' => $request->vote_val]);

				if ($request->vote_val > 0) {
					$commentOwner->notify(new CommentInteraction(['upvote', $announcement, $userVoted]));
				} else {
					$commentOwner->notify(new CommentInteraction(['downvote', $announcement, $userVoted]));
				}
			}
		}

		$sum = Vote::whereHasMorph('votable', [Comment::class])->where('votable_id', $request->comment_id)
			->sum('vote_val');

		return $sum;
	}
}
