<?php

namespace App\Models;

use App\Models\DetailNilai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
    public function detailNilai()
    {
        return $this->belongsTo(DetailNilai::class);
    }
}
