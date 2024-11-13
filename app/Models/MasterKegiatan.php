<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $fillable = ['kegiatan', 'is_custom'];

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'id_master_kegiatan');
    }
}
