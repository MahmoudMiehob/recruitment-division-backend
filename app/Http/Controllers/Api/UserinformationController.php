<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Userinformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiResponseTrait;

class UserinformationController extends Controller
{
    use ApiResponseTrait ;
    public function index(){
        $usersinfo = Userinformation::with(['user'=>function($query){
            $query->select('id','name','email','status','auth_access');
        }])->get();
        
        if($usersinfo){
            return $this->apiresponse($usersinfo,'معلومات المستخدمين',200);
        }
    }


    public function show($id){
        $userinfo = Userinformation::where('id',$id)->with(['user'=>function($query){
            $query->select('id','name','email','status','auth_access');
        }])->first();

        if($userinfo){
            return $this->apiresponse($userinfo,'معلومات المستخدم',200);
        }else{
            return $this->apiresponse(null,'حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function store(Request $request){


        $validate = Validator::make($request->all(),[
            'mother_name'         => 'required|max:50|string',
            'father_name'         => 'required|max:50|string',
            'family_name'         => 'required|max:50|string',
            'phone1'              => 'required|numeric|digits:10',
            'phone2'              => 'numeric|digits:10',
            'village'             => 'required|max:50|string',
            'region_id'           => 'required|integer|min:1',
            'national_identification_number'        => 'required|integer|min:1',
            'image'               => 'required|string',
            'user_id'             => 'required|integer|min:1',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $userinfo = Userinformation::create([
            'mother_name' => $request->mother_name ,
            'father_name' =>$request->father_name,
            'family_name' =>$request->family_name,
            'phone1'      =>$request->phone1,
            'phone2'      =>$request->phone2,
            'village'     =>$request->village,
            'region_id'   =>$request->region_id,
            'national_identification_number' =>$request->national_identification_number,
            'image'       => $request->image,
            'user_id'     =>$request->user_id,
        ]);

        if($userinfo){
            return $this->apiresponse($userinfo,'تم اضافة منطقة جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المنطقة يرجى اعادة المحاولة',400);
        }


    }
}
