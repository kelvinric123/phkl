<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Consultant;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceTypes = ['service', 'minor_procedure', 'surgical_procedure'];
        $serviceType = $this->faker->randomElement($serviceTypes);
        
        // Calculate random rate based on service type
        $rate = match($serviceType) {
            'service' => $this->faker->numberBetween(100, 300),
            'minor_procedure' => $this->faker->numberBetween(300, 800),
            'surgical_procedure' => $this->faker->numberBetween(1000, 5000),
        };
        
        // Random discount - 30% chance of having a discount, with max 20% discount
        $discountPercent = $this->faker->boolean(30) ? $this->faker->numberBetween(5, 20) : 0;
        $discountAmount = ($rate * $discountPercent) / 100;
        
        // Description based on service type
        $description = match($serviceType) {
            'service' => $this->faker->randomElement(['Initial consultation', 'Follow-up consultation']),
            'minor_procedure' => $this->faker->randomElement(['Dressing', 'Injection', 'Minor wound treatment']),
            'surgical_procedure' => $this->faker->randomElement(['Appendectomy', 'Hernia repair', 'Cholecystectomy']),
        };
        
        // Variation only applicable for service type
        $variation = $serviceType === 'service' 
            ? $this->faker->randomElement(['new', 'follow_up']) 
            : null;
        
        return [
            'invoice_id' => Invoice::factory(),
            'consultant_id' => Consultant::factory(),
            'service_type' => $serviceType,
            'variation' => $variation,
            'description' => $description,
            'rate' => $rate,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
        ];
    }
    
    /**
     * Configure the invoice item to be a service.
     */
    public function service(): self
    {
        return $this->state(function (array $attributes) {
            $isNew = $this->faker->boolean();
            $rate = $isNew ? 200 : 100; // New consultations cost more
            
            return [
                'service_type' => 'service',
                'variation' => $isNew ? 'new' : 'follow_up',
                'description' => $isNew ? 'Initial consultation' : 'Follow-up consultation',
                'rate' => $rate,
            ];
        });
    }
    
    /**
     * Configure the invoice item to be a minor procedure.
     */
    public function minorProcedure(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'service_type' => 'minor_procedure',
                'variation' => null,
                'description' => $this->faker->randomElement(['Dressing', 'Injection', 'Minor wound treatment']),
                'rate' => $this->faker->numberBetween(300, 800),
            ];
        });
    }
    
    /**
     * Configure the invoice item to be a surgical procedure.
     */
    public function surgicalProcedure(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'service_type' => 'surgical_procedure',
                'variation' => null,
                'description' => $this->faker->randomElement(['Appendectomy', 'Hernia repair', 'Cholecystectomy']),
                'rate' => $this->faker->numberBetween(1000, 5000),
            ];
        });
    }
    
    /**
     * Configure the invoice item to have a discount.
     */
    public function withDiscount(int $percent = null): self
    {
        return $this->state(function (array $attributes) use ($percent) {
            $discountPercent = $percent ?? $this->faker->numberBetween(5, 20);
            $rate = $attributes['rate'] ?? 100;
            $discountAmount = ($rate * $discountPercent) / 100;
            
            return [
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
            ];
        });
    }
} 