<?php

namespace App\Http\Controllers\files;

use App\Http\Controllers\Controller;
use App\Models\files\filesModel;
use App\Models\user\userModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 /*
  * Контроллер filesController отвечает за информацию о файле открытом в приложении
  * Так-же отвеает за изменение настроек файла
  */
class filesController extends Controller
{

    public function editname(Request $request){
        /*
         * Изменяет имя фала
         */
        $name_file = $request->input('folder_name');
        $id_file = $request->input('file_id');

        $error = "";

        if(!$name_file) {
            $error = "Ошибка, укажите новое имя файла";
        }else {
            if(!$id_file) {
                $error = "Ошибка, перезагрузите страницу";
            }else {
                $file_info = filesModel::getInfoFile($id_file);
                if(!$file_info OR !$file_info->user_id == auth::Id()) {
                    $error = "Ошибка доступа";
                }else {
                    if(!preg_replace('/[^a-zA-Zа-яА-Я0-9 ]/ui', '',$name_file )) {
                        $error = "Ошибка, разрешены только буквы и цифры";
                    }else {
                        if(mb_strlen($name_file,'UTF-8') > 15) {
                            $error = "Ошибка, название файла может быть до 15 символов";
                        }else {
                            if($file_info->type == "folder") {
                                $error = "Ошибка";
                            }
                        }
                    }
                }
            }
        }


        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {

            $mytime = Carbon::now();

            $chars = ['.'];

            $filter_name = str_replace($chars, '', $name_file); // PHP код

            $exp_name = explode('.', $file_info->name_file);

            $new_file_name = $filter_name.".".$exp_name[1];

            filesModel::editFileName($file_info->id, $new_file_name);

            DB::table('user_history')->insert([
                'user_id' => auth::id(),
                'text' => 'Переименован файл с '.$exp_name[0].'.'.$exp_name[1].' на '.$new_file_name,
                'created_at' => $mytime->toDateTimeString(),
            ]);

            $data = '{"status":"ok", "text":"Успешно"}';
        }
        return json_decode($data);

    }

    public function deletefile(Request $request) {
        /*
         * Отвечает за удаление файла
         */
        $id_file = $request->input('file_id');

        $mytime = Carbon::now();

        $error = "";

        if(!$id_file) {
            $error = "Ошибка, укажите id имя файла";
        }else {
            $file_info = filesModel::getInfoFile($id_file);
            if(!$file_info OR !$file_info->user_id == auth::Id()) {
                $error = "Ошибка, доступа";
            }
        }
        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {

            $file_hash_name = substr($file_info->storage,strrpos($file_info->storage,'/'),strlen($file_info->storage));

            Storage::delete('/public/user-'.auth::id().$file_hash_name);

            filesModel::deleteFile($file_info->id);

            userModel::limite($file_info->file_size,'up');

            DB::table('user_history')->insert([
                'user_id' => auth::id(),
                'text' => 'Файл: '.$file_info->name_file.' был удалён',
                'created_at' => $mytime->toDateTimeString(),
            ]);

            $data = '{"status":"ok", "text":"Успешно"}';
        }
        return json_decode($data);
    }

    public function sharefile(Request $request) {
        /*
         * Отвечает за функцию "Поделиться файлом"
         */
        $id_file = $request->input('file_id');

        $mytime = Carbon::now();

        $error = "";

        if(!$id_file) {
            $error = "Ошибка, укажите id имя файла";
        }else {
            $file_info = filesModel::getInfoFile($id_file);
            if(!$file_info OR !$file_info->user_id == auth::Id()) {
                $error = "Ошибка, доступа";
            }
        }

        if($error) {
            $data = '{"status":"error", "text":"'.$error.'"}';
        }else {

            if($file_info->public_link) {
                filesModel::shareFile($id_file,'close');

                DB::table('user_history')->insert([
                    'user_id' => auth::id(),
                    'text' => 'Файл: '.$file_info->name_file.' был закрыт для общего доступа',
                    'created_at' => $mytime->toDateTimeString(),
                ]);
            }else {

                filesModel::shareFile($id_file,'open');

                DB::table('user_history')->insert([
                    'user_id' => auth::id(),
                    'text' => 'Файл: '.$file_info->name_file.' был открыт для общего доступа',
                    'created_at' => $mytime->toDateTimeString(),
                ]);
            }

            $data = '{"status":"ok", "text":"Успешно"}';
        }
        return json_decode($data);
    }
}
