<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\settingsProgect;
use App\Models\blacklisttypesModel;
use App\Models\files\filesModel;
use App\Models\user\userModel;

class dashboardController extends Controller
{
    public function getPage() {

        $data['settings'] = settingsProgect::getSettings();

        $my_files = filesModel::getMyFiles(auth::id());

        $data['my_files'] = array();

        if($my_files) {
            foreach ($my_files as $file) {



                $data['my_files'][] = array(
                    'type'
                );

            }
        }



        return view('dashboard', $data);
    }

    public function add(Request $request) {
        header('Content-Type: application/json');

        $settings = settingsProgect::getSettings();

        $file_find = $request->file('file');

        $error = "";

        if(!$file_find) {
            $error = "Ошибка, выберите файл";
        }else {
            if($settings->max_file_size < $file_find->getSize() AND !$error) {
                $error = "Ошибка, максимальный замер файла 20 мб";
            }

            if(blacklisttypesModel::checkBlackListFile($file_find->getClientOriginalExtension()) AND !$error){
                $error = "Ошибка, запрещённый тип файла";
            }
        }

        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {

            $upload_folder = 'public/user-'.Auth::id();

            $filename = $file_find->getClientOriginalName();

            $filename_download = rand(100,999999)."-".rand(100,9999999).$filename;

            Storage::putFileAs($upload_folder, $file_find, $filename_download);

            Storage::download($upload_folder."/".$filename_download);

            filesModel::addFile($file_find->getClientOriginalExtension(),Storage::url($upload_folder."/".$filename_download),$file_find->getClientOriginalName());

            userModel::limite($file_find->getSize(),'down');

            $data = '{"status":"ok", "text":"Успешно"}';
        }
        return json_decode($data);

    }

    public function addFolder(Request $request) {

        header('Content-Type: application/json');

        $name_folder = $request->input('folder_name');
        $error = "";
        if(!$name_folder) {
            $error = "Ошибка, введите название папки";
        }else {
            if(mb_strlen($name_folder,'UTF-8') < 3 OR mb_strlen($name_folder,'UTF-8') > 15) {
                $error = "Ошибка, название папки может быть от 3 до 15 символов";
            }

             if(!preg_replace('/[^a-zA-Zа-яА-Я0-9 ]/ui', '',$name_folder )) {
                 $error = "Ошибка, разрешены только буквы и цифры";
             }
        }

        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {
            $generate_folder_name = rand(100,999999)."folder";

            filesModel::addFile("folder",$generate_folder_name,$name_folder);

            $data = '{"status":"ok", "text":"Успешно"}';
        }

         return json_decode($data);

    }
}
