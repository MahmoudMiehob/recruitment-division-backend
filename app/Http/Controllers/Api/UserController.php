<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiResponseTrait;

class UserController extends Controller
{

    use ApiResponseTrait;
    
    public function update(Request $request,$id){


        $validate = Validator::make($request->all(),[
            'role'         => 'required|integer',
            'status'       => 'required|integer',
        ]);
        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }


        $user = User::find($id);
        if($user){
            $user->update([
                'role'   => $request->role,
                'status' => $request->status,
            ]);
            $user->roles()->attach($request->role);
            return $this->apiresponse($user,'تم تعديل صلاحيات المستخدم بنجاح',200);

        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المنطقة يرجى اعادة المحاولة',400);
        }
    }
}
