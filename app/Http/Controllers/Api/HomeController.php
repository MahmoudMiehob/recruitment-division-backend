<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    use ApiResponseTrait ;

    public function __invoke()
    {
        $transactions = Transaction::count();
        $transactionsarchive = Transaction::onlyTrashed()->count();
        $transactionsregionaccept = Transaction::where('region_consent',1)->count();
        $transactionsprovincesaccept = Transaction::where('provinces_consent',1)->count();


        $allUser = User::count();
        $users = User::where('auth_access',1)->get()->count();
        $admin = User::where('auth_access',2)->get()->count();
        $superAdmin = User::where('auth_access',3)->get()->count();


        $array =[
            'data' => [

                'transactions count' => $transactions,
                'transactions archive count' => $transactionsarchive,
                'transactions region accept'=>$transactionsregionaccept,
                'transactions provinces accept'=>$transactionsprovincesaccept,

                'all users' => $allUser,
                'users count' => $users,
                'admin count' => $admin ,
                'super admin count' => $superAdmin ,

            ],

            'message' => 'جميع البيانات',
            'status' => 200
        ];
        return response($array,200,['جميع البيانات']);
    }
}
