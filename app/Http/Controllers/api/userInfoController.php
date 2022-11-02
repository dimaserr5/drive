<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\userModel;
use Illuminate\Http\Request;

class userInfoController extends Controller
{
    public function getUser(Request $request) {
        $api_token = $request->query('api_token');

        $user_info = userModel::getUserByApiKey($api_token);

        return $user_info;
    }

    public function getUserFiles(Request $request) {

    }

}
