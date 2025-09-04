<?php

namespace Database\Factories;

use App\Models\Activation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activation>
 */
class ActivationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // اختر نوعًا عشوائيًا
        $type = $this->faker->randomElement(['paid_version', 'trial_version', 'unlimited_version']);

        // عيّن مدة الاشتراك بناءً على النوع
        $subscriptionTime = match($type) {
            'paid_version'      => 12,
            'trial_version'     => 6,
            'unlimited_version' => 100,
        };

        return [
            'code' => Activation::generateActiveCode(),
            'type' => $type,
            'subscription_time' => $subscriptionTime,
            'created_by' => 1,
        ];
    }
}
