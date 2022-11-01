<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\settingsProgect;

class dashboardController extends Controller
{
    public function getPage() {
        $data['test'] = 1;
        return view('dashboard', $data);
    }

    public function add(Request $request) {
        header('Content-Type: application/json');

        $file_find = $request->file('file');

        if(!$file_find) {
            $error = "Ошибка, выберите файл";
        }



        if(!$error) {
            $upload_folder = 'public/folder';
            $filename = $file_find->getClientOriginalName();
            Storage::putFileAs($upload_folder, $file_find, $filename);
        }


        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {
            $data = '{"status":"ok", "text":"Успешно"}';
        }

        return json_encode($data);;

    }
}
