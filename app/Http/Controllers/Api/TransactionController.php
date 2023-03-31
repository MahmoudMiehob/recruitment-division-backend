<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    use ApiResponseTrait ;
    use UploadfileTrait ;

    public function index(){

        $transactions = Transaction::with(['user','region','province'])->get();
        if($transactions){
            return $this->apiresponse($transactions,'get all transactions',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function show($id){
        $transaction = Transaction::find($id);
        if($transaction){
            $transaction = Transaction::where('id', $id)->with(['user','region','province'])->get();
            return $this->apiresponse($transaction,'get one transactions',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function store(Request $request){
        
        $validate = Validator::make($request->all(),[
            'name'                => 'required|max:50|string',
            'region_id'           => 'required|integer|min:1',
            'province_id'         => 'required|integer|min:1',
            'region_consent'      => 'required|integer|min:1',
            'provinces_consent'   => 'required|integer|min:1',
            'notes'               => 'required|string',
            'image'               => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_id'             => 'required|integer|min:1|unique:transactions',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        //upload image
        $folder_path = $request->user_id . '/transaction';
        if($request->file('image')){
            $data['path'] = $this->uploadfile($request,$folder_path);
        }

        $transaction = Transaction::create([
            'name'           => $request->name,
            'region_id'      => $request->region_id,
            'province_id'    => $request->province_id,
            'region_consent' => $request->region_consent,
            'provinces_consent' => $request->provinces_consent,
            'notes'          => $request->notes,
            'image'          => $data['path'] ,
            'user_id'        => $request->user_id,
        ]);

        if($transaction){
            return $this->apiresponse($transaction,'تم اضافة معاملة جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المعاملة يرجى اعادة المحاولة',400);
        }   

    }

    public function update(Request $request , $id){
        $validate = Validator::make($request->all(),[
            'name'                => 'required|max:50|string',
            'region_id'           => 'required|integer|min:1',
            'province_id'         => 'required|integer|min:1',
            'region_consent'      => 'required|integer|min:1',
            'provinces_consent'   => 'required|integer|min:1',
            'notes'               => 'required|string',
            'image'               => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_id'             => 'required|integer|min:1',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $transaction = Transaction::find($id);
        if($transaction){

            Storage::disk('img')->delete($transaction->image);

            $folder_path = $request->user_id . '/transaction';
            if($request->file('image')){
                $data['path'] = $this->uploadfile($request,$folder_path);
            }

            $transaction->update([
                'name'           => $request->name,
                'region_id'      => $request->region_id,
                'province_id'    => $request->province_id,
                'region_consent' => $request->region_consent,
                'provinces_consent' => $request->provinces_consent,
                'notes'          => $request->notes,
                'image'          => $data['path'] ,
                'user_id'        => $request->user_id,
            ]) ;

            if($transaction){
                return $this->apiresponse($transaction,'تم تعديل المعاملة بنجاح',200);
            }else{
                return $this->apiresponse(null,'عذرا لم يتم تعديل المعاملة يرجى اعادة المحاولة',400);
            }   

        }else{
            return $this->apiresponse(null,'عذرا المعاملة غير موجودة',500);
        }
    }


    public function delete($id){

        $transaction = Transaction::find($id);
        if(!$transaction){
            return $this->apiresponse(null,'عذرا المستخدم غير موجودة',500);
        }else{
            $transaction->delete($transaction);
            if($transaction){
                return $this->apiresponse(null,'تم حذف البيانات بنجاح',200);
            }else{
                return $this->apiresponse(null,'حدثت مشكلة يرجى المحاولة لاحقا',400);
            }
        }

    }
}
