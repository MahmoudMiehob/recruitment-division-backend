<?php

namespace App\Models;

use App\Models\Region;
use App\Models\Recruitment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function recruitments()
    {
        return $this->hasMany(Recruitment::class);
    }
}
