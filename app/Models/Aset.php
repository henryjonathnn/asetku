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
        'id_master_jenis',
        'nomor_aset',
        'serial_number',
        'part_number',
        'spek',
        'pengguna',
        'status',
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

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_master_jenis')
            ->select(['id', 'jenis']);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_aset')
            ->select(['id', 'id_aset', 'id_master_kegiatan', 'id_user', 'created_at']);
    }

    public static function getStatusOptions()
    {
        return [
            'baik' => 'Baik',
            'kurang_layak' => 'Kurang Layak',
            'rusak' => 'Rusak'
        ];
    }

    protected function getStatusFormattedAttribute()
    {
        $statuses = [
            'baik' => 'Baik',
            'kurang_layak' => 'Kurang Layak', 
            'rusak' => 'Rusak'
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}
