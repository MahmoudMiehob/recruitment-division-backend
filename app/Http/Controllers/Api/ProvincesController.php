<?php

namespace App\Http\Controllers\Api;

use App\Models\Provinces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvincesController extends Controller
{
    use ApiResponseTrait ;

    public function index(){
        $provinces = Provinces::all();
        return $this->apiresponse($provinces,'get all provinces',200);
    }
}
