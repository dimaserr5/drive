<?php

namespace App\Http\Controllers;

use App\Http\Controllers\tools\toolsController;
use App\Models\files\filesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class fileInfoController extends Controller
{
    public function file_info($id) {

        if(!$id) {
            return view('dashboard');
        }else {

            $file_info = filesModel::getInfoFile($id);

            if($file_info AND $file_info->user_id == auth::Id()) {

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

                return view('fileinfo',$data);

            }else {
                return to_route('dashboard');
            }
        }
    }
}
