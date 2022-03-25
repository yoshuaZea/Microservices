<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthenticateAccess {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        // Obtain a list of valid secrets
        $validSecrets = explode(',', env('ACCEPTED_SECRETS'));

        // Check each valid secret key against the authorization header
        if(in_array($request->header('Authorization'), $validSecrets)){
            return $next($request);
        }

        // In case the authorization header against secrets key is not valid
        abort(Response::HTTP_UNAUTHORIZED);
    }
}
