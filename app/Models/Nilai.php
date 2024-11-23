<?php

namespace App\Models;

use App\Models\Guru;
use App\Models\DetailNilai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function detailNilais(){
        return $this->hasMany(DetailNilai::class);
    }
}
