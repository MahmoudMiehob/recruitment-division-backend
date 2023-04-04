<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcceptController extends Controller
{
    use ApiResponseTrait;
    public function acceptregion(Request $request , $id){
        $transaction = Transaction::find($id);

        if($transaction){
            $transaction->update([
                'region_consent'=> 1 
            ]);
            return $this->apiresponse($transaction,'تمت الموافقة من قبل المنطقة',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function rejectregion(Request $request , $id){
        $transaction = Transaction::find($id);

        if($transaction){
            $transaction->update([
                'region_consent'=> 0
            ]);
            return $this->apiresponse($transaction,'تمت الرفض من قبل المنطقة',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }



    public function acceptprovince(Request $request , $id){
        $transaction = Transaction::find($id);

        if($transaction){
            $transaction->update([
                'provinces_consent'=> 1 
            ]);
            return $this->apiresponse($transaction,' تمت الموافقة من قبل المحافظة',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }

    public function rejectprovince(Request $request , $id){
        $transaction = Transaction::find($id);

        if($transaction){
            $transaction->update([
                'provinces_consent'=> 0
            ]);
            return $this->apiresponse($transaction,'تم الرفض من قبل المحافظة',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }
}
