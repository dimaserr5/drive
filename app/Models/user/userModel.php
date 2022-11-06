<?php

namespace App\Models\user;

use App\Http\Controllers\tools\toolsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
 * Модель userModel отвечает за получении и изменении информации о пользователе в БД
 */
/**
 * App\Models\user\userModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|userModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userModel query()
 * @mixin \Eloquent
 */
class userModel extends Model
{

    public static function getUser($user_id){

        /*
         * Метод getUser отвечает за вывод информации о пользователе
         */

        $user = DB::table('users')->where('id', $user_id)->first();

        return $user;

    }

    public static function getUserApiKey($user_id){
        /*
         * Метод getUserApiKey отвечает за вывод api ключа из бд
         */
        $api_key = DB::table('api_keys')->where('user_id', $user_id)->first();
        return $api_key;
    }

    public static function addApiKey($user_id){
        /*
         * Метод addApiKey отвечает за добавление api ключа в бд
         */
        DB::table('api_keys')->insert([
            'api_key' => toolsController::generateRandomString(30),
            'user_id' => auth::id(),
        ]);
    }

    public static function limite($limite, $type){
         /*
          * Метод limite отвечает за повышение/понижение лимита у пользователя
          */
        $user_info = self::getUser(auth::id());

        if($type == "up") {
            $new_limit = $user_info->mem_limit + $limite;
        }else {
            $new_limit = $user_info->mem_limit - $limite;
        }

        DB::table('users')
            ->where('id', $user_info->id)
            ->update(['mem_limit' => $new_limit]);

    }
    use HasFactory;
}
