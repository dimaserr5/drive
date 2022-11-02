<?php

namespace App\Models\files;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class filesModel extends Model
{
    public static function addFile($file_type,$file_storage,$name_file){
        $mytime = Carbon::now();

        DB::table('user_files')->insert([
            'type' => $file_type,
            'storage' => $file_storage,
            'user_id' => auth::id(),
            'name_file' => $name_file,
            'created_at' => $mytime->toDateTimeString(),
        ]);
        DB::table('user_history')->insert([
            'user_id' => auth::id(),
            'text' => 'Добавлен: '.$file_type,
            'created_at' => $mytime->toDateTimeString(),
        ]);

    }

     public static function getMyFiles($user_id){

         $files = DB::table('user_files')->where('user_id', $user_id)->get();

         return $files;
     }

     public static function getFileAttr($type) {



     }
    use HasFactory;
}
