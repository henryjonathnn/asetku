<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepemilikan extends Model
{
    use HasFactory;

    protected $table = 'kepemilikans';

    protected $fillable = ['kepemilikan',];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'id_kepemilikan');
    }
}
