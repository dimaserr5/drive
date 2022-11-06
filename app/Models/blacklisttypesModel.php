<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*
 * Модель blacklisttypesModel отвечает за поиск запрещённых типов файла
 */

/**
 * App\Models\blacklisttypesModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|blacklisttypesModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|blacklisttypesModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|blacklisttypesModel query()
 * @mixin \Eloquent
 */
class blacklisttypesModel extends Model
{
    public static function checkBlackListFile($types){

        /*
         * Метод показывает, запрещённый тип файла или нет
         */

        $check = DB::table('black_list_types')->where('types', $types)->first();
        if($check){
            return 1;
        }else {
            return 0;
        }
    }
    use HasFactory;
}
