<?php

namespace App\Models\files;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class filesModel extends Model
{
    public static function addFile($file_type,$file_storage,$name_file, $size){
        $mytime = Carbon::now();

        DB::table('user_files')->insert([
            'type' => $file_type,
            'storage' => $file_storage,
            'user_id' => auth::id(),
            'name_file' => $name_file,
            'file_size' => $size,
            'public_link' => "",
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

     public static function getInfoFile($file_id){
         $file = DB::table('user_files')->where('id', $file_id)->first();

         return $file;
     }

     public static function getFileAttr($type) {

         $type_file = DB::table('file_attr')->where('type', $type)->first();

         return $type_file;

     }

     public static function editFileName($file_id, $name){
         DB::table('user_files')
             ->where('id', $file_id)
             ->update(['name_file' => $name]);
     }
    use HasFactory;
}
