<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
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

        $transactions = Transaction::with(['user','region','province','enlistment_statue','transactiontype'])->get();
        if($transactions){
            return $this->apiresponse($transactions,'get all transactions',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function show($id){
        $transaction = Transaction::find($id);
        if($transaction){
            $transaction = Transaction::where('id', $id)->with(['user','region','province','enlistment_statue','transactiontype'])->get();
            return $this->apiresponse($transaction,'get one transactions',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }



    public function edit($id){
        $transaction = Transaction::find($id);
        if($transaction){
            $transaction = Transaction::where('id', $id)->with(['user','region','province','enlistment_statue','transactiontype'])->get();
            return $this->apiresponse($transaction,'تعديل معلومات المعاملة',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }


    public function showalltransaction($id){
        $transaction = Transaction::where('user_id',$id)->with(['user','region','province','transactiontype','enlistment_statue'])->get();
        if($transaction){
            return $this->apiresponse($transaction,'جميع المعاملات المتعلقة بالشخص',200);
        }else{
            return $this->apiresponse(null,'عذرا حدث خطأ يرجى اعادة المحاولة',500);
        }
    }



    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'name'                              => 'required|max:50|string',
            'mother_name'                       => 'required|max:50|string',
            'father_name'                       => 'required|max:50|string',
            'family_name'                       => 'required|max:50|string',
            'phone1'                            => 'required|min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'village_number'                    => 'required|integer|min:1',
            'national_identification_number'    => 'required|min:8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'front_face_of_identity'            => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'back_face_of_identity'             => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'attached_image'                    => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_image'                        => 'image|mimes:jpg,png,jpeg,gif,svg',
            'region_id'                         => 'required|integer|min:1',
            'province_id'                       => 'required|integer|min:1',
            'transactiontype_id'                => 'required|integer|min:1',
            'enlistment_statue_id'              => 'required|integer|min:1',
            'notes'                             => 'required|string',
            'user_id'                           => 'required|integer|min:1',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        //upload image
        $folder_path = $request->user_id . '/transaction' . '/' .$request->transactiontype_id.'_'.time();

        if($request->file('front_face_of_identity')){
            $inputName = 'front_face_of_identity';
            $data['path_front_face'] = $this->uploadfile($request,$folder_path,$inputName);
        }
        if($request->file('back_face_of_identity')){
            $inputName = 'back_face_of_identity';
            $data['path_back_face'] = $this->uploadfile($request,$folder_path,$inputName);
        }
        if($request->file('attached_image')){
            $inputName = 'attached_image';
            $data['path_attached'] = $this->uploadfile($request,$folder_path,$inputName);
        }
        if($request->file('user_image')){
            $inputName = 'user_image';
            $data['path_user'] = $this->uploadfile($request,$folder_path,$inputName);
        }

        $transaction = Transaction::create([
            'name'                    => $request->name,
            'mother_name'             => $request->mother_name,
            'father_name'             => $request->father_name,
            'family_name'             => $request->family_name,
            'phone1'                  => $request->phone1,
            'village_number'          => $request->village_number,
            'national_identification_number'=> $request->national_identification_number,
            'front_face_of_identity'  => $data['path_front_face'],
            'back_face_of_identity'   => $data['path_back_face'],
            'attached_image'          => $data['path_attached'],
            'user_image'              => $data['path_user'],
            'region_id'               => $request->region_id,
            'province_id'             => $request->province_id,
            'transactiontype_id'      => $request->transactiontype_id,
            'enlistment_statue_id'    => $request->enlistment_statue_id,
            'notes'                   => $request->notes,
            'user_id'                 => $request->user_id,
        ]);

        if($transaction){
            return $this->apiresponse($transaction,'تم اضافة معاملة جدبدة بنجاح',200);
        }else{
            return $this->apiresponse(null,'عذرا لم يتم اضافة المعاملة يرجى اعادة المحاولة',400);
        }

    }

    public function update(Request $request , $id){
        $validate = Validator::make($request->all(),[
            'name'                              => 'required|max:50|string',
            'mother_name'                       => 'required|max:50|string',
            'father_name'                       => 'required|max:50|string',
            'family_name'                       => 'required|max:50|string',
            'phone1'                            => 'required|min:10|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'village_number'                    => 'required|integer|min:1',
            'national_identification_number'    => 'required|min:8|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'front_face_of_identity'            => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'back_face_of_identity'             => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'attached_image'                    => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_image'                        => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'region_id'                         => 'required|integer|min:1',
            'province_id'                       => 'required|integer|min:1',
            'transactiontype_id'                => 'required|integer|min:1',
            'notes'                             => 'required|string',
            'user_id'                           => 'required|integer|min:1',
        ]);

        if ($validate->fails()){
            return $this->apiresponse(null,$validate->errors(),500);
        }

        $transaction = Transaction::find($id);
        if($transaction){

            Storage::disk('img')->delete([
                $transaction->front_face_of_identity,
                $transaction->back_face_of_identity,
                $transaction->attached_image,
                $transaction->user_image
            ]);


            //upload image
            $folder_path = $request->user_id . '/transaction';

            if($request->file('front_face_of_identity')){
                $inputName = 'front_face_of_identity';
                $data['path_front_face'] = $this->uploadfile($request,$folder_path,$inputName);
            }
            if($request->file('back_face_of_identity')){
                $inputName = 'back_face_of_identity';
                $data['path_back_face'] = $this->uploadfile($request,$folder_path,$inputName);
            }
            if($request->file('attached_image')){
                $inputName = 'attached_image';
                $data['path_attached'] = $this->uploadfile($request,$folder_path,$inputName);
            }
            if($request->file('user_image')){
                $inputName = 'user_image';
                $data['path_user'] = $this->uploadfile($request,$folder_path,$inputName);
            }

            $transaction->update([
                'name'                    => $request->name,
                'mother_name'             => $request->mother_name,
                'father_name'             => $request->father_name,
                'family_name'             => $request->family_name,
                'phone1'                  => $request->phone1,
                'village_number'          => $request->village_number,
                'national_identification_number'=> $request->national_identification_number,
                'front_face_of_identity'  => $data['path_front_face'],
                'back_face_of_identity'   => $data['path_back_face'],
                'attached_image'          => $data['path_attached'],
                'user_image'              => $data['path_user'],
                'region_id'               => $request->region_id,
                'province_id'             => $request->province_id,
                'transactiontype_id'      => $request->transactiontype_id,
                'notes'                   => $request->notes,
                'user_id'                 => $request->user_id,
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
            return $this->apiresponse(null,'عذرا المعاملة غير موجودة',500);
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
