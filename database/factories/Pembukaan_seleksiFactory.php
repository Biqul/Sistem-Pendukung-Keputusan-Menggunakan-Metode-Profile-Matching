<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembukaan_seleksi>
 */
class Pembukaan_seleksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $iaas = "Open Recruitment IAAS Batch-";

        return [
            'nama' => $iaas.$this->faker->numberBetween(1,50),
            'status_id' => $this->faker->numberBetween(1,2),
            'slug' => $this->faker->slug(),
            'periode' => $this->faker->year(),
            'published_at' => $this->faker->dateTimeBetween('-1 year','+1 month')

        ];
    }
}
