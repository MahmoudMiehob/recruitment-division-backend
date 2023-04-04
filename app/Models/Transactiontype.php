<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactiontype extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
