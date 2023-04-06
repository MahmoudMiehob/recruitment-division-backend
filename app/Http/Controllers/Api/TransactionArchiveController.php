<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\ApiResponseTrait;

class TransactionArchiveController extends Controller
{

    use ApiResponseTrait ;
    public function index(){
        $transactionarchives = Transaction::onlyTrashed()->with(['user','region','province'])->get();
        if($transactionarchives){
            return $this->apiresponse($transactionarchives,'get all transactions archive',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function show($id){

        $transactionarchive = Transaction::withTrashed()->where('deleted_at','!=',null)
        ->with(['user','region','province'])->find($id);
        if($transactionarchive){
            return $this->apiresponse($transactionarchive,'get one transactions archive',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function restore($id){
        $transactionarchiverestore = Transaction::withTrashed()->find($id)->restore();
        if($transactionarchiverestore){
            return $this->apiresponse($transactionarchiverestore,'تم استعادة المعاملة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function delete($id){
        
        $transaction = Transaction::withTrashed()->where('id',$id)->first();

        if(!$transaction){
            return $this->apiresponse(null,'عذرا المعاملة غير موجودة',500);
        }else{
            Storage::disk('img')->delete([
                $transaction->front_face_of_identity,
                $transaction->back_face_of_identity,
                $transaction->attached_image,
                $transaction->user_image
            ]);

            $transaction->forceDelete($transaction);
            if($transaction){
                return $this->apiresponse(null,'تم حذف البيانات بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }
}
