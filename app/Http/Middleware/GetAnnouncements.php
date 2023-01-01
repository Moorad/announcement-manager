<?php

namespace App\Http\Middleware;

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

		$announcementVotes = DB::table('announcement_votes')->selectRaw('announcement_id, SUM(vote_val) as vote_sum')->groupBy('announcement_id');

		$announcements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.id')->leftJoinSub($announcementVotes, 'announcement_votes', function ($join) {
			$join->on('announcement_votes.announcement_id', '=', 'announcements.id');
		})->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'announcement_votes.vote_sum')->where('org_id', $request->attributes->get('org_data')->id)->get();

		$request->attributes->add(['announcements' => $announcements]);
		return $next($request);
	}
}
