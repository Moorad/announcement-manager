<?php

namespace App\Http\Middleware;

use App\Models\Organisation;
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
		$organisation = Organisation::where('admin_id', '=', Auth::user()->id)->first();

		if ($organisation == null) {
			$request->attributes->add(['has_org' => false, 'org_data' => null]); #

			return $next($request);
		}

		$request->attributes->add(['has_org' => true, 'org_data' => $organisation]);

		return $next($request);
	}
}
