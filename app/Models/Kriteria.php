<?php

namespace App\Models;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
