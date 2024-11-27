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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($nilai) {
            $detail = DetailNilai::where('nilai_id', $nilai->id)->get();
            foreach ($detail as $d) {
                $d->delete();
            }
        });
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function detailNilais(){
        return $this->hasMany(DetailNilai::class);
    }
}
