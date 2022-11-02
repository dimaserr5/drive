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
        $api_token = $request->query('api_token');

        $files = userModel::getUserFiles($api_token );

        return $files;
    }

    public function getUserFilesInfo(Request $request) {
        $api_token = $request->query('api_token');
        $file_id = $request->query('file_id');

        if(empty($file_id)) {
            return 403;
        }else {
            $file_info = userModel::getFile($api_token,$file_id);
            return $file_info;
        }
    }

}
