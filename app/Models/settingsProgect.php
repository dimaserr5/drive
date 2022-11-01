<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class settingsProgect extends Model
{
    public static function getSettings() {
        $settings =  DB::table('settings')->where('id', 1)->first();

        return $settings;
    }
    use HasFactory;
}
