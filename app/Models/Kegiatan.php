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
        'id_master_kegiatan',
        'custom_kegiatan',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function masterKegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class, 'id_master_kegiatan');
    }
}
