<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\QuestionAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionAnswerController extends Controller
{

    use ApiResponseTrait ;

    public function index(){
        
        $questionAnswer = QuestionAnswer::all();
        if($questionAnswer){
            return $this->apiresponse($questionAnswer,'get all questions and answer',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'question'         => 'required|string',
            'answer'           => 'required|string',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $questionAnswer = QuestionAnswer::create([
            'question'=>$request->question,
            'answer'=>$request->answer
        ]);

        if($questionAnswer){
            return $this->apiresponse($questionAnswer,'تم اضافة السؤال بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة السؤال يرجى اعادة المحاولة',400);
        }

    }

    public function update($id , Request $request){
        $validate = Validator::make($request->all(),[
            'question'         => 'required|string',
            'answer'           => 'required|string',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $questionAnswer = QuestionAnswer::find($id);
        if($questionAnswer){
            $questionAnswer->update([
                'question'=>$request->question,
                'answer'=>$request->answer
            ]);
            return $this->apiresponse($questionAnswer,'تم تعديل السؤال بنجاح',200);
        }else{
            return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
        }
    }


    public function delete($id){
        $questionAnswer = QuestionAnswer::find($id);
        if(!$questionAnswer){
            return $this->apiresponse(null,'عذرا السؤال غير موجودة',500);
        }else{
            $questionAnswer->delete($id);
            if($questionAnswer){
                return $this->apiresponse(null,'تم حذف السؤال بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }
}
