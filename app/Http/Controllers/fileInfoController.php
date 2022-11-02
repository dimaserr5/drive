<?php

namespace App\Http\Controllers;

use App\Models\files\filesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

                $filter_fail= explode('.',$file_info->name_file);

                $data['filter_fail_name'] = $filter_fail[0];


                return view('fileinfo',$data);
            }else {
                return to_route('dashboard');
            }
        }
    }
}
