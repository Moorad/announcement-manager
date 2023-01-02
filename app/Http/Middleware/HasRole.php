<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasRole
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next, ...$roles)
	{
		$user = User::where('id', Auth::user()->id)->first();

		if ($user == null) {
			return redirect()->to(route('login'));
		}

		foreach ($roles as $role) {
			if ($user->role == $role) {
				return $next($request);
			}
		}

		return redirect()->to(route('home'));
	}
}
