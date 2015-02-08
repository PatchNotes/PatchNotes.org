<?php namespace PatchNotes\Http\Middleware;

use Closure;
use Sentry;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if( ! Sentry::check()) {
			if ($request->ajax())
			{
				return response()->json(['success' => false, 'error' => 'Unauthorized.'], 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}

		return $next($request);
	}

}
