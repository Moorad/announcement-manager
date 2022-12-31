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
		$announcements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.id')->select('announcements.*', 'users.name as user_name', 'users.role as user_role')->where('org_id', $request->attributes->get('org_data')->id)->get();
		$request->attributes->add(['announcements' => $announcements]);
		return $next($request);
	}
}
