<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class userModel extends Model
{

    public static function getUser($user_id){

        $user = DB::table('users')->where('id', $user_id)->first();

        return $user;

    }

    public static function limite($limite, $type){

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
