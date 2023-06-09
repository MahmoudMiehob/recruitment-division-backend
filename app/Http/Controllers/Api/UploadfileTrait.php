<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

trait UploadfileTrait {

    public function uploadfile(Request $request,$folder_name,$inputName){

        //$extension = $request->file($inputName)->extension();
        $image = $request->file($inputName)->getClientOriginalName();
        $path = $request->file($inputName)->storeAs($folder_name,$image,'img');
        return $path;

    }

}
