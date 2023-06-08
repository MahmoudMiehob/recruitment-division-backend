<?php

namespace App\Models;

use App\Models\Recruitment;
use App\Models\Transaction;
use App\Models\Userinformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enlistment_statue extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public $timestamps = false;

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function recruitments()
    {
        return $this->hasMany(Recruitment::class);
    }

    public function users(){
        return $this->hasMany(Userinformation::class);
    }
}
