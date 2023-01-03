<?php

namespace App\Http\Middleware;

use App\Models\Announcement;
use App\Models\Vote;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetAnnouncements
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if ($request->attributes->get('in_org') == null && $request->attributes->get('owns_org') == null) {
			$request->attributes->add(['announcements' => []]);
			return $next($request);
		}

		$announcementVotes = Vote::whereHasMorph('votable', [Announcement::class])->selectRaw('votable_id, SUM(vote_val) as vote_sum')->groupBy('votable_id');


		$commentCount = DB::table('comments')->selectRaw('announcement_id, COUNT(announcement_id) as comment_count')->groupBy('announcement_id');

		$announcements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.id')
			->leftJoinSub($announcementVotes, 'votes', function ($join) {
				$join->on('votes.votable_id', '=', 'announcements.id');
			})
			->leftJoinSub($commentCount, 'comments', function ($join) {
				$join->on('comments.announcement_id', '=', 'announcements.id');
			})
			->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'votes.vote_sum', 'comments.comment_count')->where('org_id', $request->attributes->get('org_data')->id)
			->orderByRaw('announcements.priority = "high" DESC, announcements.updated_at DESC')->paginate(20);

		$request->attributes->add(['announcements' => $announcements]);
		return $next($request);
	}
}
