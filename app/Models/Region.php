<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable =['name','provinces_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
