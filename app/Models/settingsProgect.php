<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*
 * Модель settingsProgect отвечает за настройки проекта
 */

class settingsProgect extends Model
{
    public static function getSettings() {
        /*
        * Метод getSettings отвечает за получение настроек проекта
        */
        $settings =  DB::table('settings')->where('id', 1)->first();

        return $settings;
    }
    use HasFactory;
}
