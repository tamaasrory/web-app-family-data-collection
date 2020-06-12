<?php

namespace App;

/**
 * Class Datakk
 * @package App
 *
 * @property string $id
 * @property string $kode_akses
 * @property array $anggota_keluarga
 * @property array $alamat
 * @property string $no_hp
 * @property string $created_at
 * @property string $updated_at
 */
class DataSensus extends Model
{
    protected $table = 'data_sensus';
    protected $fillable = [
        'id',
        'kode_akses',
        'anggota_keluarga',
        'alamat',
        'no_hp',
        'created_at',
        'updated_at',
    ];

    protected $casts=[
        'anggota_keluarga' => 'json',
        'alamat' => 'json',
    ];
}
