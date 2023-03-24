<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    use ApiResponseTrait ;

    public function index(){

        $transactions = Transaction::with(['user'=>function($query){
            $query->select('id','name','email','status','auth_access');
        }])->get();

        if($transactions){
            return $this->apiresponse($transactions,'get all transactions',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }
}
