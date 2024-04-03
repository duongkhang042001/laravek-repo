<?php

namespace Database\Factories\MT;

use App\Models\MT\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MT\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $telcoOptions = [1, 2, 3, 4, 5, 6];

        $partnerId = 3615;

        $total = $this->faker->randomElement([100, 101, 120, 200, 220, 140, 1000, 1600, 2400, 5000, 10000]);

        return [
            'partner_id' => $partnerId,
            'telco' => $this->faker->randomElement($telcoOptions),
            'mo_subscription_id' => $this->faker->randomElement([1, 2, 3]),
            'mo_sms_total' => $total,
            'mt_sms_total' => $total,
            'mt_cdr_total' => $this->faker->randomElement([$total, $total - 1, $total - 2, $total - 3, $total, $total]),
            'date' => $this->faker->dateTimeThisMonth(),
            'amount' => (float) $total * 200
        ];
    }
}
