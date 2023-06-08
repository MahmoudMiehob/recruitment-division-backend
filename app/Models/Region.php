<?php

namespace App\Models;

use App\Models\Province;
use App\Models\Recruitment;
use App\Models\Transaction;
use App\Models\Userinformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable =['name','provinces_id'];
    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function recruitments()
    {
        return $this->hasMany(Recruitment::class);
    }


    public function usersinfo()
    {
        return $this->hasMany(Userinformation::class);
    }
}
