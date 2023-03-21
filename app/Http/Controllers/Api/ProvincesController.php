<?php

namespace App\Http\Controllers\Api;

use App\Models\Region;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvincesController extends Controller
{
    use ApiResponseTrait ;

    public function index(){
        $provinces = Province::all();
        return $this->apiresponse($provinces,'get all provinces',200);
    }

    public function show($id){

        $province = Province::find($id);
        if($province){
            $region = Region::where('provinces_id',$id)->get();
            if($region){
                return $this->apiresponse($region,'جميع المناطق المتعلقة بالمحافظة',200);
            }else{
                return $this->apiresponse(null,'لم يتم العثور على مناطق تابعة للمحافظة',500);
            }
        } else{
            return $this->apiresponse(null,'المحافظة غير موجودة يرجى اعادة المحاولة',500);
        }  
    }
}
