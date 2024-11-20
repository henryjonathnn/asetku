<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepemilikan extends Model
{
    use HasFactory;

    // protected $table = 'kepemilikans';

    protected $fillable = ['kepemilikan', 'is_active'];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'id_kepemilikan');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getActiveKepemilikan()
    {
        $activeKepemilikan = Kepemilikan::active()->get();
        return response()->json($activeKepemilikan);
    }
}
