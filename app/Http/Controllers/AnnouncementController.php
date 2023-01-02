<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementVote;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
	public function __construct()
	{
		$this->middleware('has_role:admin,announcer', ['only' => ['create', 'store', 'update', 'edit']]);
	}

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
		return view('announcements.create', ['user' => Auth::user()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$post = new Announcement;
		$post->user_id = Auth::user()->id;
		$post->org_id = $request->attributes->get('org_data')->id;
		$post->title = $request->announcement_title;
		$post->text = $request->announcement_text;

		if ($request->hasFile('announcement_image')) {
			$request->validate([
				'image' => 'mimes:png,jpeg,jpg,svg,webp'
			]);

			$request->file('announcement_image')->store('announcement_images', 'public');

			$post->attached_image = $request->file('announcement_image')->hashName();
		}

		$post->save();

		return redirect()->to(route('home'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$announcementVotes = AnnouncementVote::selectRaw('announcement_id, SUM(vote_val) as vote_sum')->groupBy('announcement_id');

		$announcement = Announcement::join('users', 'announcements.user_id', '=', 'users.id')
			->leftJoinSub($announcementVotes, 'announcement_votes', function ($join) {
				$join->on('announcement_votes.announcement_id', '=', 'announcements.id');
			})
			->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'announcement_votes.vote_sum')
			->where('announcements.id', $id)->first();

		if ($announcement == null) {
			return abort(404);
		}

		$comments = Comment::where('announcement_id', $id)
			->join('users', 'users.id', 'comments.user_id')
			->select('comments.*', 'users.name as user_name', 'users.role as user_role')->get();

		return view('announcements.show', ['user' => Auth::user(), 'announcement' => $announcement, 'comments' => $comments]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return view('announcements.edit', ['user' => Auth::user()]);
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function update_vote(Request $request)
	{
		$userVoteExists = AnnouncementVote::where('announcement_id', $request->announcement_id)
			->where('user_id', $request->user_id);

		if ($userVoteExists->first() == null) {
			$vote = new AnnouncementVote;
			$vote->announcement_id = $request->announcement_id;
			$vote->user_id = $request->user_id;
			$vote->vote_val = $request->vote_val;
			$vote->save();
		} else {
			if ($userVoteExists->first()->vote_val == $request->vote_val) {
				$userVoteExists->delete();
			} else {
				$userVoteExists->update(['vote_val' => $request->vote_val]);
			}
		}

		$sum = AnnouncementVote::where('announcement_id', $request->announcement_id)
			->sum('vote_val');

		return $sum;
	}
}
