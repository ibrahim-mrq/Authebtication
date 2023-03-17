<?php

namespace App\Http\Middleware;

use App\Traits\BaseTrait;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenMiddleware
{
    use BaseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        if ($token == null) {
            //  return $next($this->returnError(401, ['Unauthorized!']));
            return $this->returnError(401, ['Unauthorized!']);
        }
        $findToken = PersonalAccessToken::findToken($token);
        if (!$findToken) {
            return $this->returnError(401, ['Unauthorized!']);
        }
        $request->headers->set('user', $findToken->tokenable_id);
        return $next($request);
    }
}