<?php

namespace App\Http\Middleware;

use App\Models\Organisation;
use App\Models\UserOrganisation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasOrg
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
		$ownsOrg = Organisation::where('admin_id', '=', Auth::user()->id)->first();
		$inOrg = UserOrganisation::where('user_id', Auth::user()->id)->whereNotNull('org_id')->first();

		if ($ownsOrg != null) {
			$request->attributes->add(['owns_org' => $ownsOrg, 'org_data' => $ownsOrg]);
		} else if ($inOrg) {
			$request->attributes->add(['owns_org' => null, 'org_data' => Organisation::where('id', $inOrg->org_id)->first(), 'in_org' => $inOrg]);
		} else {
			$request->attributes->add(['owns_org' => null, 'org_data' => null, 'in_org' => null]);
		}

		return $next($request);
	}
}
