<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kegiatans';

    protected $fillable = [
        'id_aset',
        'id_user',
        'kegiatan',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
