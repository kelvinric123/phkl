<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Consultant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $dueDate = clone $invoiceDate;
        $dueDate->modify('+30 days');
        
        return [
            'patient_id' => Patient::factory(),
            'consultant_id' => Consultant::factory(),
            'invoice_number' => 'PHKL250P' . $invoiceDate->format('ymd') . sprintf('%04d', rand(1, 9999)),
            'payment_mode' => $this->faker->randomElement(['cash', 'gl']),
            'patient_type' => $this->faker->randomElement(['outpatient', 'inpatient']),
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
            'notes' => $this->faker->optional(0.7)->sentence,
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0,
            'is_foreigner' => $this->faker->boolean(20), // 20% chance of being a foreigner
            'foreigner_surcharge' => 0,
            'after_office_hours' => $this->faker->boolean(30), // 30% chance of being after hours
            'total_discount' => 0,
        ];
    }
    
    /**
     * Configure the invoice to be in draft status.
     */
    public function draft(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
            ];
        });
    }
    
    /**
     * Configure the invoice for a foreigner patient.
     */
    public function foreigner(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_foreigner' => true,
            ];
        });
    }
    
    /**
     * Configure the invoice as after office hours.
     */
    public function afterHours(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'after_office_hours' => true,
            ];
        });
    }
} 