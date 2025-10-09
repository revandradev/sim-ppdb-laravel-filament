<?php
namespace Database\Seeders;

use App\Models\Pendaftaran;
use Illuminate\Database\Seeder;

class pendaftaraneeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pendaftaran::factory()->count(50)->create();
    }
}
