<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\DB;

class AuthenticateApi extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        $api_token = $request->query('api_token');

        if(!empty($api_token)) {
            $api_info = DB::table('api_keys')
                ->where('api_key', '=', $api_token)
                ->first();
            if($api_info) {
                return;
            }else {
                return 403;
            }
        }else {
            return 403;
        }
    }

}
