<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'alamat_domisili',
        'nama_ayah',
        'nama_ibu',
        'no_hp_ortu',
        'asal_sekolah',
        'foto',
        'user_pendaftaran_id',
        'alamat_sekolah_sebelumnya',
        'akte_kelahiran',
        'kartu_keluarga',
        'rapor_terakhir',
        'ijazah',
        'is_submitted',
        'is_verified',
    ];

    public function userPendaftaran()
    {
        return $this->belongsTo(UserPendaftaran::class, 'user_pendaftaran_id');
    }
    public function getStatusVerifikasiAttribute()
    {
        return $this->is_verified ? 'Terverifikasi' : 'Belum diverifikasi';
    }
    public function getStatusApprovalAttribute()
    {
        return $this->is_approved ? 'Diterima' : 'Menunggu hasil';
    }
    public function filePendaftaran()
    {
        return $this->hasMany(FilePendaftaran::class, 'user_pendaftaran_id');
    }
}
