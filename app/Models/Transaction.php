<?php

namespace App\Models;

use App\Models\User;
use App\Models\Region;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name','region_id','province_id','region_consent','provinces_consent','notes','image','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    } 

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
