<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code =  $this->faker->unique()->currencyCode();


        $currencies = [
            'USD' => ['symbol' => '$', 'name' => 'United States Dollar'],
            'EUR' => ['symbol' => '€', 'name' => 'Euro'],
            'GBP' => ['symbol' => '£', 'name' => 'British Pound Sterling'],
            'JPY' => ['symbol' => '¥', 'name' => 'Japanese Yen'],
            'AUD' => ['symbol' => 'A$', 'name' => 'Australian Dollar'],
            'CAD' => ['symbol' => 'C$', 'name' => 'Canadian Dollar'],
            // Add more as needed
        ];

        $symbol = $currencies[$code]['symbol'] ?? '$';
        $name = $currencies[$code]['name'] ?? 'Unknown Currency';

        return [
            "code" => $code,
            "symbol" => $symbol,
            "name" => $name,
            "rate" => $this->faker->randomFloat(4, 0.1, 5)
        ];
    }
}