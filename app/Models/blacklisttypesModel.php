<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class blacklisttypesModel extends Model
{
    public static function checkBlackListFile($types){
        $check = DB::table('black_list_types')->where('types', $types)->first();
        if($check){
            return 1;
        }else {
            return 0;
        }
    }
    use HasFactory;
}
