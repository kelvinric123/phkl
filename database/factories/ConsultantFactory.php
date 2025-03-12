<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Consultant;
use App\Models\Specialty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultant>
 */
class ConsultantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Consultant::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->randomElement(['Dr.', 'Prof.', 'Mr.', 'Mrs.', 'Ms.']),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'specialty' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics']),
            'hourly_rate' => $this->faker->randomFloat(2, 100, 500),
            'notes' => $this->faker->optional(0.7)->sentence(),
            'specialty_id' => function () {
                // Create a specialty if none exist
                if (Specialty::count() === 0) {
                    return Specialty::create([
                        'name' => $this->faker->word()
                    ])->id;
                }
                return Specialty::inRandomOrder()->first()->id;
            },
        ];
    }
} 