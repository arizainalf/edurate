<?php

namespace App\Models;

use App\Models\Guru;
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
}
