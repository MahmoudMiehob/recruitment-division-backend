<?php

namespace App\Http\Controllers\Api;

use App\Models\Recruitment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RecruitmentController extends Controller
{

    use ApiResponseTrait ;

    public function index(){

        $recruitment = Recruitment::with(['region','province','enlistment_statue'])->get();
        if($recruitment){
            return $this->apiresponse($recruitment,'get all recruitment',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function show($id){
        $recruitment = Recruitment::find($id);
        if($recruitment){
            $recruitment = Recruitment::where('id', $id)->with(['region','province','enlistment_statue'])->get();
            return $this->apiresponse($recruitment,'get one recruitment',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function edit($id){
        $recruitment = Recruitment::find($id);
        if($recruitment){
            $recruitment = Recruitment::where('id', $id)->with(['region','province','enlistment_statue'])->get();
            return $this->apiresponse($recruitment,'تعديل معلومات التجنيد',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function store(Request $request){


        $validate = Validator::make($request->all(),[
            'name'                => 'required|max:50|string',
            'mother_name'         => 'required|max:50|string',
            'father_name'         => 'required|max:50|string',
            'family_name'         => 'required|max:50|string',
            'village_number'      => 'required|integer',
            'enlistment_statue_id'=> 'required|integer',
            'region_id'           => 'required|integer|min:1',
            'province_id'         => 'required|integer|min:1',
            'national_identification_number'  => 'required|min:8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'service_started'      => 'required|date',
            'service_ended'      => 'required|date|after_or_equal:service_started',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }


        $service_started = Carbon::parse($request->service_started)->format('Y-m-d');
        $service_ended = Carbon::parse($request->service_ended)->format('Y-m-d');

        $recruitment = Recruitment::create([
            'name'        => $request->name ,
            'mother_name' => $request->mother_name ,
            'father_name' =>$request->father_name,
            'family_name' =>$request->family_name,
            'enlistment_statue_id' => $request-> enlistment_statue_id,
            'village_number'  => $request-> village_number,
            'region_id'   =>$request->region_id,
            'province_id'   =>$request->province_id,
            'national_identification_number' =>$request->national_identification_number,
            'service_started'      => $service_started,
            'service_ended'      => $service_ended,
        ]);

        if($recruitment){
            return $this->apiresponse($recruitment,'تم اضافة معلومات جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة معلومات التجنيد يرجى اعادة المحاولة',400);
        }        
    }



    public function update(Request $request , $id){
        $validate = Validator::make($request->all(),[
            'name'                => 'required|max:50|string',
            'mother_name'         => 'required|max:50|string',
            'father_name'         => 'required|max:50|string',
            'family_name'         => 'required|max:50|string',
            'village_number'      => 'required|integer',
            'enlistment_statue_id'=> 'required|integer',
            'region_id'           => 'required|integer|min:1',
            'province_id'         => 'required|integer|min:1',
            'national_identification_number'  => 'required|min:8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'service_started'      => 'required|date',
            'service_ended'        => 'required|date|after_or_equal:service_started',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }


        $service_started = Carbon::parse($request->service_started)->format('Y-m-d');
        $service_ended = Carbon::parse($request->service_ended)->format('Y-m-d');
        
        $recruitment = Recruitment::find($id);
        if($recruitment){

            $recruitment->update([
                'name'        => $request->name ,
                'mother_name' => $request->mother_name ,
                'father_name' =>$request->father_name,
                'family_name' =>$request->family_name,
                'enlistment_statue_id' => $request-> enlistment_statue_id,
                'village_number'  => $request-> village_number,
                'region_id'   =>$request->region_id,
                'province_id'   =>$request->province_id,
                'national_identification_number' =>$request->national_identification_number,
                'service_started'      => $service_started,
                'service_ended'      => $service_ended,
            ]);

            $recruitment = Recruitment::where('id',$id)->with(['region','province','enlistment_statue'])->first();

            return $this->apiresponse($recruitment,'تم تعديل البيانات بنجاح',200);
        }else{
            return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
        }
    }



    public function delete($id){
        $recruitment = Recruitment::find($id);
        if(!$recruitment){
            return $this->apiresponse(null,'عذرا معلومات التجنيد غير موجودة',500);
        }else{
            $recruitment->delete($id);
            if($recruitment){
                return $this->apiresponse(null,'تم حذف معلومات التجنيد بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }

}
