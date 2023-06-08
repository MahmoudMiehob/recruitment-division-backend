<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Userinformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiResponseTrait;

class UserinformationController extends Controller
{
    use ApiResponseTrait ;
    use UploadfileTrait ;


    public function index(){
        $usersinfo = Userinformation::with(['user','region','enlistment_statue'])->get();
        
        if($usersinfo){
            return $this->apiresponse($usersinfo,'معلومات المستخدمين',200);
        }
    }



    public function show($id){
        $userinfo = Userinformation::where('id',$id)->with(['user','region','enlistment_statue'])->first();

        if($userinfo){
            return $this->apiresponse($userinfo,'معلومات المستخدم',200);
        }else{
            return $this->apiresponse(null,'حدث خطأ يرجى اعادة المحاولة',500);
        }
    }



    public function edit($id){
        $userinfo = Userinformation::where('id',$id)->with(['user','region','enlistment_statue'])->first();

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
            'phone1'              => 'required|min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone2'              => 'min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'village_number'      => 'required|integer',
            'enlistment_statue_id'=> 'required|integer',
            'region_id'           => 'required|integer|min:1',
            'national_identification_number'  => 'required|min:8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image'               => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_id'             => 'required|integer|min:1|unique:userinformations',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        //upload image
        $folder_path = $request->user_id . '/user';
        $inputName ='image';
        if($request->file('image')){
            $data['path'] = $this->uploadfile($request,$folder_path,$inputName);
        }

        $userinfo = Userinformation::create([
            'mother_name' => $request->mother_name ,
            'father_name' =>$request->father_name,
            'family_name' =>$request->family_name,
            'phone1'      =>$request->phone1,
            'phone2'      =>$request->phone2,
            'enlistment_statue_id' => $request-> enlistment_statue_id,
            'village_number'  => $request-> village_number,
            'region_id'   =>$request->region_id,
            'national_identification_number' =>$request->national_identification_number,
            'image'       => $data['path'] ,
            'user_id'     =>$request->user_id,
        ]);

        if($userinfo){
            return $this->apiresponse($userinfo,'تم اضافة معلومات جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المنطقة يرجى اعادة المحاولة',400);
        }        
    }


    public function update(Request $request , $id){
        $validate = Validator::make($request->all(),[
            'mother_name'         => 'required|max:50|string',
            'father_name'         => 'required|max:50|string',
            'family_name'         => 'required|max:50|string',
            'phone1'              => 'required|min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone2'              => 'min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'village_number'      => 'required|integer',
            'enlistment_statue_id'=> 'required|integer',
            'region_id'           => 'required|integer|min:1',
            'national_identification_number'        => 'required|min8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image'               => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_id'             => 'required|integer|min:1',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        
        $userinfo = Userinformation::find($id);
        if($userinfo){

            Storage::disk('img')->delete($userinfo->image);

            $folder_path = $request->user_id . '/user';
            $inputName ='image';
            if($request->file('image')){
                $data['path'] = $this->uploadfile($request,$folder_path,$inputName);
            }

            $userinfo->update([
                'mother_name' => $request->mother_name ,
                'father_name' =>$request->father_name,
                'family_name' =>$request->family_name,
                'phone1'      =>$request->phone1,
                'phone2'      =>$request->phone2,
                'enlistment_statue_id' => $request-> enlistment_statue_id,
                'village_number'  => $request-> village_number,
                'region_id'   =>$request->region_id,
                'national_identification_number' =>$request->national_identification_number,
                'image'       => $data['path'],
                'user_id'     =>$request->user_id,
            ]);

            $userinfo = Userinformation::where('id',$id)->with(['user'=>function($query){
                $query->select('id','name','email','status_id','role');
            }])->first();

            return $this->apiresponse($userinfo,'تم تعديل البيانات بنجاح',200);
        }else{
            return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
        }
    }

    public function delete($id){
        
        $userinfo = Userinformation::find($id);
        if(!$userinfo){
            return $this->apiresponse(null,'عذرا المستخدم غير موجودة',500);
        }else{
            $userinfo->delete($id);
            if($userinfo){
                return $this->apiresponse(null,'تم حذف البيانات بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }
}
