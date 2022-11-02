<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\settingsProgect;
use App\Models\blacklisttypesModel;

class dashboardController extends Controller
{
    public function getPage() {

        $data['settings'] = settingsProgect::getSettings();



        return view('dashboard', $data);
    }

    public function add(Request $request) {
        header('Content-Type: application/json');

        $settings = settingsProgect::getSettings();

        $file_find = $request->file('file');

        $error = "";

        if(!$file_find) {
            $error = "Ошибка, выберите файл";
        }

        if($settings->max_file_size < $file_find->getSize()) {
            $error = "Ошибка, максимальный замер файла 20 мб";
        }

        if(blacklisttypesModel::checkBlackListFile($file_find->getClientOriginalExtension())){
            $error = "Ошибка, запрещённый тип файла";
        }

        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {

            $upload_folder = 'public/user-'.Auth::id();
            $filename = $file_find->getClientOriginalName();
            $filename_download = rand(100,999999)."-".rand(100,9999999).$filename;
            Storage::putFileAs($upload_folder, $file_find, $filename_download);
            Storage::download($upload_folder."/".$filename_download);
            echo Storage::url($upload_folder."/".$filename_download);
            exit();


             //$data = '{"status":"ok", "text":"Успешно"}';
        }

        return json_decode($data);

    }
}
