<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\user\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
 * Контроллер profileController отвечает за вывод информации об аккаунте в приложении
 */

class profileController extends Controller
{
    public function get() {

        /*
         * Отвечает за запрос информации об профиле
         */

        $user_info = userModel::getUser(auth::id());

        $data['user_name'] = $user_info->name;
        $data['user_email'] = $user_info->email;
        $data['user_date_reg'] = $user_info->created_at;

        $api = userModel::getUserApiKey(auth::id());

        if($api) {
            $data['api_key'] = $api->api_key;
        }else {
            $data['api_key'] = "";
        }

        return view('profile.profile',$data);
    }

    public function getapi(Request $request) {

        /*
         * Отвечает за запрос информации об api ключах
         */

        header('Content-Type: application/json');

        $check_key = userModel::getUserApiKey(auth::Id());

        $error = "";

        if($check_key) {
            $error = "Ошибка, у вас уже есть ключ";
        }

        if(!$error) {

            userModel::addApiKey(auth::Id());

            $data = '{"status":"ok", "text":"Успешно"}';
        }else {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }

        return json_decode($data);

    }
}
