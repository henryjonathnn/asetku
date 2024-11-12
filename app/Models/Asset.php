<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_barang',
        'jenis',
        'serial_number',
        'part_number',
        'spek',
        'tahun_kepemilikan',
        'id_kepemilikan',
    ];

    protected $cast = [
        'tahun_kepemilikan' => 'integer',
    ];

    public function kepemilikan()
    {
        return $this->belongsTo(Kepemilikan::class, 'id_kepemilikan');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_aset');
    }
}
