<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunMasuk extends Model
{
    protected $table = 'tahun_masuk';

    protected $fillable = [
        'tahun',
        'is_aktif',
    ];
}
