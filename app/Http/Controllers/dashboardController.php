<?php

namespace App\Http\Controllers;

use App\Http\Controllers\tools\toolsController;
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

        $user_info = userModel::getUser(auth::id());

        $my_files = filesModel::getMyFiles(auth::id());

        $data['my_files'] = array();

        if($my_files) {
            foreach ($my_files as $file) {

                $atr = filesModel::getFileAttr($file->type);

                if($atr) {
                    $image = $atr->img;
                }else {
                    $image = "/storage/imgs/files_img/file.png";
                }

                $data['my_files'][] = array(
                    'image' => $image,
                    'name' => substr($file->name_file, 0, 12),
                    'storage' => $file->storage,
                    'type' => $file->type,
                    'id' => $file->id,
                );

            }

            $my_files_all = filesModel::getMyFiles(auth::id(),'all');

            $data['all_size_file'] = 0;

            if($my_files_all) {
                foreach ($my_files_all as $file) {

                    $data['all_size_file'] = $data['all_size_file'] + $file->file_size;

                }
            }
        }

        $data['all_size_file'] = toolsController::formatSizeUnits($data['all_size_file']);

        $data['access_size'] = toolsController::formatSizeUnits($user_info->mem_limit);

        return view('dashboard', $data);
    }

    public function getPageFolder($folder) {
        if(!$folder) {
            return redirect(view('dashboard'));
        }else {
            $get_folder = filesModel::checkFolder($folder);
            if(!$get_folder OR $get_folder->user_id !== auth::id()) {
                return redirect(view('dashboard'));
            }else {

                $my_files = filesModel::getMyFiles(auth::id(),$folder);

                $data['my_files'] = array();
                $data['folder_size'] = 0;

                if($my_files) {
                    foreach ($my_files as $file) {

                        $atr = filesModel::getFileAttr($file->type);

                        if($atr) {
                            $image = $atr->img;
                        }else {
                            $image = "/storage/imgs/files_img/file.png";
                        }

                        $data['my_files'][] = array(
                            'image' => $image,
                            'name' => substr($file->name_file, 0, 12),
                            'storage' => $file->storage,
                            'type' => $file->type,
                            'id' => $file->id,
                        );

                        $data['folder_size'] = $data['folder_size'] + $file->file_size;

                    }
                }


                $data['folder_name_storage'] = $folder;
                $data['folder_name'] = $get_folder->name_file;
                $data['folder_size'] = toolsController::formatSizeUnits($data['folder_size']);
                return view('dashboardfolder', $data);
            }
        }
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

            if($request->input('folder')) {
                filesModel::addFile($file_find->getClientOriginalExtension(),Storage::url($upload_folder."/".$filename_download),$file_find->getClientOriginalName(),$file_find->getSize(),$request->input('folder'));
            }else {
                filesModel::addFile($file_find->getClientOriginalExtension(),Storage::url($upload_folder."/".$filename_download),$file_find->getClientOriginalName(),$file_find->getSize());
            }

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

            filesModel::addFile("folder",$generate_folder_name,$name_folder,'0');

            $data = '{"status":"ok", "text":"Успешно"}';
        }

         return json_decode($data);

    }
}
