<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenis extends Model
{
    use HasFactory;

    protected $fillable = ['jenis', 'is_active'];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'id_master_jenis');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
