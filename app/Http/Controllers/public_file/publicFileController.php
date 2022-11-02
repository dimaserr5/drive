<?php

namespace App\Http\Controllers\public_file;

use App\Http\Controllers\Controller;
use App\Http\Controllers\tools\toolsController;
use App\Models\files\filesModel;
use Illuminate\Http\Request;

class publicFileController extends Controller
{
    public function get($file) {
        $file_info = filesModel::getPublicFile($file);

        if(!$file_info) {
            return "Файл не найден";
        }else {
            $data['file_name'] = $file_info->name_file;
            $data['file_storage'] = $file_info->storage;
            $data['file_id'] = $file_info->id;
            $data['file_size'] = toolsController::formatSizeUnits($file_info->file_size);
            $data['file_date'] = $file_info->created_at;

            if($file_info->public_link) {
                $data['file_public_link'] = "http://".$_SERVER['SERVER_NAME']."/".$file_info->public_link;
            }else {
                $data['file_public_link'] = "";
            }

            $filter_fail= explode('.',$file_info->name_file);

            $data['filter_fail_name'] = $filter_fail[0];
            $data['filter_fail_ext'] = $filter_fail[1];
            return view('public_file.public_file',$data);
        }
    }
}
