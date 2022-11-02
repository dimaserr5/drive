<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class userModel extends Model
{
    public static function getUserByApiKey($api_key){
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
    use HasFactory;
}
