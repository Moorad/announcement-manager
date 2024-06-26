<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\TagAnnouncement;
use App\Models\User;
use App\Notifications\AnnouncementCreated;
use App\Notifications\AnnouncementInteraction;
use App\Notifications\AnnouncementUpdated;
use App\Services\GiphyAPI;
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
		$tags = Tag::all();
		return view('announcements.create', ['user' => Auth::user(), 'tags' => $tags]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, GiphyAPI $GiphyService)
	{
		$validate = $request->validate([
			'announcement_title' =>  ['required', 'max:255'],
			'announcement_text' =>  ['required', 'max:750']

		]);
		$announcement = new Announcement;
		$announcement->user_id = Auth::user()->id;
		$announcement->org_id = $request->attributes->get('org_data')->id;
		$announcement->title = $request->announcement_title;
		$announcement->text = $request->announcement_text;
		$announcement->priority = $request->announcement_priority;

		if ($request->hasFile('announcement_image')) {
			$request->validate([
				'image' => 'mimes:png,jpeg,jpg,svg,webp'
			]);

			$request->file('announcement_image')->store('announcement_images', 'public');

			$announcement->attached_image = $request->file('announcement_image')->hashName();
		} else if ($request->giphy_gif_src) {
			$hashed_name = $GiphyService->saveGif($request->giphy_gif_src);

			$announcement->attached_image = $hashed_name;
		}

		$announcement->save();

		if ($request->announcement_tags) {
			foreach ($request->announcement_tags as $tag_id) {
				$tag = new TagAnnouncement;
				$tag->tag_id = $tag_id;
				$tag->announcement_id = $announcement->id;
				$tag->save();
			}
		}

		if ($request->announcement_priority == 'high' || $request->announcement_priority == 'normal') {
			$users = User::join('user_organisations', 'users.id', 'user_organisations.user_id')
				->where('org_id', $request->attributes->get('org_data')->id)
				->get();

			foreach ($users as $user) {
				$user->notify(new AnnouncementCreated([$announcement]));
			}
		}

		return redirect()->to(route('announcements.show', $announcement->id))->with('success', 'The announcement has been created successfully!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$announcementVotes = Vote::whereHasMorph('votable', [Announcement::class])->selectRaw('votable_id, SUM(vote_val) as vote_sum')->groupBy('votable_id');

		$announcement = Announcement::join('users', 'announcements.user_id', '=', 'users.id')
			->leftJoinSub($announcementVotes, 'votes', function ($join) {
				$join->on('votes.votable_id', '=', 'announcements.id');
			})
			->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'votes.vote_sum')
			->where('announcements.id', $id)->first();

		if ($announcement == null) {
			return abort(404);
		}

		$commentVotes = Vote::whereHasMorph('votable', [Comment::class])->selectRaw('votable_id, SUM(vote_val) as vote_sum')->groupBy('votable_id');

		$comments = Comment::where('announcement_id', $id)
			->join('users', 'users.id', 'comments.user_id')
			->leftJoinSub($commentVotes, 'votes', function ($join) {
				$join->on('votes.votable_id', '=', 'comments.id');
			})
			->select('comments.*', 'users.name as user_name', 'users.role as user_role', 'votes.vote_sum')->orderBy('updated_at', 'desc')->get();

		$tags = TagAnnouncement::where('announcement_id', $id)->join('tags', 'tags.id', 'tag_announcements.tag_id')->get();
		return view('announcements.show', ['user' => Auth::user(), 'announcement' => $announcement, 'comments' => $comments, "tags" => $tags]);
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
		$announcement = Announcement::where('id', $id)->first();

		if ($user->id != $announcement->user_id && $user->role != 'admin') {
			return redirect()->to(route('home'));
		}

		return view('announcements.edit', ['user' => Auth::user(), 'announcement' => $announcement]);
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
		$announcement = Announcement::where('id', $id);

		if ($user->id != $announcement->first()->user_id && $user->role != 'admin') {
			return redirect()->to(route('home'));
		}

		$announcement->update(['title' => $request->announcement_title, 'text' => $request->announcement_text, 'edited' => true, "priority" => $request->announcement_priority]);

		if ($request->announcement_priority == 'high' || $request->announcement_priority == 'normal') {
			$users = User::join('user_organisations', 'users.id', 'user_organisations.user_id')
				->where('org_id', $request->attributes->get('org_data')->id)
				->get();

			foreach ($users as $user) {
				$user->notify(new AnnouncementUpdated([$announcement->first()]));
			}
		}

		return redirect()->to(route('announcements.show', $announcement->first()->id))->with('success', 'The announcement has been updated successfully!');;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Announcement::find($id)->delete();

		return redirect()->to(route('home'))->with('success', 'The announcement has been deleted successfully!');
	}

	public function update_vote(Request $request)
	{
		$userVoteExists = Vote::whereHasMorph('votable', [Announcement::class])->where('votable_id', $request->announcement_id)
			->where('user_id', $request->user_id);

		$userVoted = User::where('id', $request->user_id)->first();
		$announcement = Announcement::where('id', $request->announcement_id)->first();
		$announcementOwner = User::where('id', $announcement->user_id)->first();

		if ($userVoteExists->first() == null) {
			$vote = new Vote;
			$vote->votable_id = $request->announcement_id;
			$vote->votable_type = Announcement::class;
			$vote->user_id = $request->user_id;
			$vote->vote_val = $request->vote_val;
			$vote->save();

			if ($request->vote_val > 0) {
				$announcementOwner->notify(new AnnouncementInteraction(['upvote', $announcement, $userVoted]));
			} else {
				$announcementOwner->notify(new AnnouncementInteraction(['downvote', $announcement, $userVoted]));
			}
		} else {
			if ($userVoteExists->first()->vote_val == $request->vote_val) {
				$userVoteExists->delete();
			} else {
				$userVoteExists->update(['vote_val' => $request->vote_val]);

				if ($request->vote_val > 0) {
					$announcementOwner->notify(new AnnouncementInteraction(['upvote', $announcement, $announcementOwner]));
				} else {
					$announcementOwner->notify(new AnnouncementInteraction(['downvote', $announcement, $announcementOwner]));
				}
			}
		}

		$sum = Vote::whereHasMorph('votable', [Announcement::class])->where('votable_id', $request->announcement_id)
			->sum('vote_val');

		return $sum;
	}
}
