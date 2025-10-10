<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use SoftDeletes;
    protected $table    = 'tarif';
    protected $fillable = ['nama_tarif', 'deskripsi', 'jumlah', 'kode_tarif', 'is_active'];
}
