<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftaran>
 */
class PendaftaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap'  => $this->faker->name(),
            'nisn'          => $this->faker->unique()->numerify('##########'),
            'tempat_lahir'  => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-12 years'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat'        => $this->faker->address(),
            'nama_ayah'     => $this->faker->name('male'),
            'nama_ibu'      => $this->faker->name('female'),
            'no_hp_ortu'    => $this->faker->phoneNumber(),
            'asal_sekolah'  => $this->faker->company(),
            'foto'          => $this->faker->imageUrl(300, 400, 'people', true, 'student'),
        ];
    }
}
