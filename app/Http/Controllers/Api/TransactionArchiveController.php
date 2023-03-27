<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class TransactionArchiveController extends Controller
{

    use ApiResponseTrait ;
    public function index(){
        $transactionarchives = Transaction::onlyTrashed()->get();
        if($transactionarchives){
            return $this->apiresponse($transactionarchives,'get all transactions archive',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function show($id){

        $transactionarchive = Transaction::withTrashed()->where('deleted_at','!=',null)->find($id);
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
        $transaction = Transaction::find($id);
        if(!$transaction){
            return $this->apiresponse(null,'عذرا المستخدم غير موجودة',500);
        }else{
            $transaction->forceDelete($transaction);
            if($transaction){
                return $this->apiresponse(null,'تم حذف البيانات بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }
    }
}
