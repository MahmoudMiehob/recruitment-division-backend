<?php

namespace App\Models;

use App\Models\User;
use App\Models\Region;
use App\Models\Enlistment_statue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Userinformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'mother_name',
        'father_name',
        'family_name',
        'phone1',
        'phone2',
        'village',
        'image',
        'region_id',
        'village_number',
        'enlistment_statue_id',
        'national_identification_number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    } 

    public function enlistment_statue()
    {
        return $this->belongsTo(Enlistment_statue::class);
    }
}
