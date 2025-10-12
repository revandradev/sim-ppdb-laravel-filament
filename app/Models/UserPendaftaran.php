<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class UserPendaftaran extends User
{
    /** @use HasFactory<\Database\Factories\UserPendaftaranFactory> */
    use HasFactory, Notifiable;
    protected $table    = 'user_pendaftaran';
    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
    ];
    public function fill(array $attributes): static
    {
        if (isset($attributes['name'])) {
            $attributes['nama_lengkap'] = $attributes['name'];
            unset($attributes['name']);
        }
        return parent::fill($attributes);
    }
    public function setNameAttribute(string $value): void
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama_lengkap'] ?? null;
    }
}
