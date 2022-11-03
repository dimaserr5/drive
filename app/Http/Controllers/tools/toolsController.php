<?php

namespace App\Http\Controllers\tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/*
 * Контроллер toolsController отвечает за вспомогательные элементы на сайте
 */
class toolsController extends Controller
{
    public static function formatSizeUnits($bytes)
    {
        /*
         * Отвечает за подсчёт размера файла
         */

        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function generateRandomString($length = 10) {
        /*
         * Отвечает за генерацию рамномного значения
         */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
