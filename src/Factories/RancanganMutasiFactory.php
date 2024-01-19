<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\RancanganMutasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\RancanganMutasi>
 */
class RancanganMutasiFactory extends Factory
{
    protected $model = RancanganMutasi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->sentence(3),
            'tanggal_mulai' => $tanggal_mulai = fake()->dateTimeBetween('-1 week', '+1 week'),
            'tanggal_berakhir' => now()->parse($tanggal_mulai)->addWeeks(2),
            'is_selesai' => fake()->boolean(25),
        ];
    }
}
