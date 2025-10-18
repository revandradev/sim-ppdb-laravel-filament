<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilePendaftaran extends Model
{
    protected $table = 'file_pendaftaran';

    protected $fillable = [
        'user_pendaftaran_id',
        'file_name',
        'file_path',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'user_pendaftaran_id');
    }
}
