<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

trait UploadfileTrait {

    public function uploadfile(Request $request,$folder_name){

        $image = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs($folder_name,$image,'img');
        
        return $path;
    }

}