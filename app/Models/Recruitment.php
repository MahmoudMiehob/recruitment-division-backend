<?php

namespace App\Models;

use App\Models\Region;
use App\Models\Province;
use App\Models\Enlistment_statue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruitment extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }


    public function enlistment_statue()
    {
        return $this->belongsTo(Enlistment_statue::class);
    }

}
