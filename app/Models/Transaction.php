<?php

namespace App\Models;

use App\Models\User;
use App\Models\Region;
use App\Models\Province;
use App\Models\Transactiontype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [] ;

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

    public function transactiontype()
    {
        return $this->belongsTo(Transactiontype::class);
    }
}
