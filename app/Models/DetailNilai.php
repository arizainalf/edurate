<?php

namespace App\Models;

use App\Models\Nilai;
use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailNilai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }
}
