<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_barang',
        'jenis',
        'serial_number',
        'part_number',
        'spek',
        'pengguna',
        'tahun_kepemilikan',
        'id_kepemilikan',
    ];

    protected $casts = [
        'tahun_kepemilikan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Define relationship with eager loading constraints
    public function kepemilikan()
    {
        return $this->belongsTo(Kepemilikan::class, 'id_kepemilikan')
            ->select(['id', 'kepemilikan']);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_aset')
            ->select(['id', 'id_aset', 'id_master_kegiatan', 'id_user', 'created_at']);
    }
}
