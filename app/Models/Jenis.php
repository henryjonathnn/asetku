<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
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

    public function getActiveJenis()
    {
        $activeJenis = Jenis::active()->get();
        return response()->json($activeJenis);
    }
}
