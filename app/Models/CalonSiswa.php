<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalonSiswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'calon_siswa';

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'no_hp_ortu',
        'asal_sekolah',
    ];
}
