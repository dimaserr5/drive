<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateApi extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        $api_token = $request->query('api_token');



        if(!empty($api_token)) {
            return;
        }else {
            $this->unauthenticated($request,$guards);
        }
    }

}
