<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*
 * Модель userModel отвечает за получение информации об пользователии/файлах из бд посредством api
 */

/**
 * App\Models\api\userModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|userModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userModel query()
 * @mixin \Eloquent
 */
class userModel extends Model
{
    public static function getUserByApiKey($api_key){

        /*
         * Отвечает за получение мнформации о пользователе посредством  api ключа
         */

        $api_info = DB::table('api_keys')
            ->where('api_key', '=', $api_key)
            ->first();

        if($api_info) {
            $user_info = DB::table('users')
                ->where('id', '=', $api_info->user_id)
                ->first();

            if($user_info) {
                return $user_info;
            }else {
                return "Api User Not Found";
            }
        }else {
            return 403;
        }
    }

    public static function getUserFiles($api_key) {
        /*
         * Отвечает за получение мнформации о всех файлах пользователя посредством api ключа
         */
        $api_info = DB::table('api_keys')
            ->where('api_key', '=', $api_key)
            ->first();

        if($api_info) {
            $user_info = DB::table('users')
                ->where('id', '=', $api_info->user_id)
                ->first();

            if($user_info) {

                $files = DB::table('user_files')
                    ->where('user_id', '=', $user_info->id)
                        ->get();

                if($files) {
                    return $files;
                }else {
                    return "Error, files not found";
                }

            }else {
                return "Api User Not Found";
            }
        }else {
            return 403;
        }
    }

    public static function getFile($api_key, $file_id){
        /*
         * Отвечает за получение мнформации о файле пользователя посредством api ключа
         */
        $api_info = DB::table('api_keys')
            ->where('api_key', '=', $api_key)
            ->first();

        if($api_info) {
            $user_info = DB::table('users')
                ->where('id', '=', $api_info->user_id)
                ->first();

            if($user_info) {

                $file = DB::table('user_files')
                    ->where('id', '=', $file_id)
                    ->where('user_id', '=', $user_info->id)
                    ->first();

                if($file){
                    return $file;
                }else {
                    return "Error, file not found";
                }

            }else {
                return "Api User Not Found";
            }
        }
    }
    use HasFactory;
}
