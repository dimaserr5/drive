<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\userModel;
use Illuminate\Http\Request;
/*
 *   Данный контроллер отвечает за взаимодействие с пользователем посредством api ключа
 *   В каждый из запросов передаётся api ключ, сгенерированный из лк в приложении
 */
class userInfoController extends Controller
{
    public function getUser(Request $request) {
        /*
         *  Возвращает полную информацию о пользователе
         */
        $api_token = $request->query('api_token');

        $user_info = userModel::getUserByApiKey($api_token);

        return $user_info;
    }

    public function getUserFiles(Request $request) {
        /*
         *  Возвращает полную информацию о всех файлах пользователя
         */
        $api_token = $request->query('api_token');

        $files = userModel::getUserFiles($api_token );

        return $files;
    }

    public function getUserFilesInfo(Request $request) {
        /*
         *  Возвращает полную информацию об определённо фале пользователя
         */
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
