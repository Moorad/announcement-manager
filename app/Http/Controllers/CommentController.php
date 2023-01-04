<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use App\Models\User;
use App\Models\Vote;
use App\Notifications\AnnouncementInteraction;
use App\Notifications\CommentInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$comment = new Comment;
		$comment->announcement_id = $request->announcement_id;
		$comment->user_id = $request->user_id;
		$comment->content = $request->content;
		$comment->save();

		$comments = Comment::where('announcement_id', $request->announcement_id)
			->join('users', 'users.id', 'comments.user_id')
			->select('comments.*', 'users.name as user_name', 'users.role as user_role')->orderBy('updated_at', 'desc')->get();


		$userCommented = User::where('id', $request->user_id)->first();
		$announcement = Announcement::where('id', $request->announcement_id)->first();
		$announcementOwner = User::where('id', $announcement->user_id)->first();

		$announcementOwner->notify(new AnnouncementInteraction(['comment', $announcement, $userCommented]));

		return view('layouts.comments', ['comments' => $comments, 'user' => Auth::user(), 'comment_success' => 'The comment has been created successfully!']);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user = User::where('id', Auth::user()->id)->first();
		$comment = Comment::where('id', $id)->first();

		if ($user->id != $comment->user_id && $user->role != 'admin') {
			return redirect()->to(route('home'));
		}

		return view('comments.edit', ["user" => Auth::user(), 'comment' => $comment]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$user = User::where('id', Auth::user()->id)->first();
		$comment = Comment::where('id', $id);

		if ($user->id != $comment->first()->user_id && $user->role != 'admin') {
			return redirect()->to(route('home'));
		}

		$comment->update(['content' => $request->comment_content]);

		return redirect()->to(route('announcements.show', $comment->first()->announcement_id))->with('comment-success', 'The comment has been updated successfully!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$comment = Comment::find($id);

		$comment->delete();

		return redirect()->back()->with('comment-success', 'The comment has been deleted successfully!');
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
