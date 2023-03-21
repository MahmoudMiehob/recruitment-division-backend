<?php

namespace App\Http\Controllers\Api;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiResponseTrait;

class RegionController extends Controller
{
    use ApiResponseTrait ;

    public function index(){
        $regions = Region::all();
        return $this->apiresponse($regions,'get all regions',200);
    }

    public function show($id){
        $region = Region::find($id);
        if($region){
            return $this->apiresponse($region,'معلومات المنطقة',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم العثور على المنطقة',400);
        }
    }


    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'name'         => 'required|max:50|unique:regions|string',
            'provinces_id' => 'required|integer|min:1|lt:14',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $region = Region::create([
            'name' => $request->name ,
            'provinces_id' =>$request->provinces_id
        ]);

        if($region){
            return $this->apiresponse($region,'تم اضافة منطقة جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المنطقة يرجى اعادة المحاولة',400);
        }
    }


    public function update(Request $request, $id){
        $validate = Validator::make($request->all(),[
            'name'         => 'required|max:50|unique:regions|string',
            'provinces_id' => 'required|integer|min:1|lt:14',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $region = Region::find($id);
        if($region){
            $region->update([
                'name' => $request->name ,
                'provinces_id' =>$request->provinces_id
            ]);
            return $this->apiresponse($region,'تم تعديل المنطقة بنجاح',200);
        }else{
            return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
        }

    }


    public function delete($id){
        $region = Region::find($id);
        if(!$region){
            return $this->apiresponse(null,'عذرا المنطقة غير موجودة',500);
        }else{
            $region->delete($id);
            if($region){
                return $this->apiresponse(null,'تم حذف المنطقة بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }

}
