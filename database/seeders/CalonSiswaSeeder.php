<?php
namespace Database\Seeders;

use App\Models\CalonSiswa;
use Illuminate\Database\Seeder;

class CalonSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CalonSiswa::factory()->count(100)->create();
    }
}
