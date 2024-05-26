<?php

namespace App\Models\Map;

use App\Models\File\PhotoIrrigationBuilding;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangunanIrigasi extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'map.irrigations_building';

    protected $fillable = [
        'nama_bangunan',
        'tipe_saluran',
        'jarak',
        'b_saluran  ',
        'sempadan_kanan ',
        'sempadan_kiri',
        'luas_saluran',
        'sisi_terluar_kanan',
        'sisi_terluar_kiri',
        'saluran_kanan',
        'saluran_panjang_kanan',
        'saluran_kiri',
        'saluran_panjang_kiri',
        'keterangan',
        'created_at',
        'updated_at',
        'geom'
    ];

    protected $casts = [
        'jarak' => 'float',
        'b_saluran' => 'float',
        'sempadan_kanan' => 'float',
        'sempadan_kiri' => 'float',
        'luas_saluran' => 'float',
        'saluran_panjang_kanan' => 'float',
        'saluran_panjang_kiri' => 'float',
    ];

    public function photo()
    {
        return $this->hasMany(PhotoIrrigationBuilding::class, 'building_id');
    }
}
