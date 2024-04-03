<?php

namespace Database\Factories\MT;

use App\Models\MT\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    //generate fake phone number with modify "0385563490"
    protected function generatePhoneNumber()
    {
        $areaCode = '038';
        $number = mt_rand(1000000, 9999999);
        return $areaCode . $number;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $telcoOptions = [1, 2, 3, 4, 5, 6];
        $partnerIdStart = 550;
        $partnerIdEnd = 1000;
        $lastMonth = now()->subMonth();
        $thisMonth = now();
        $faker = \Faker\Factory::create();
        // $partner = $this->faker->numberBetween($partnerIdStart, $partnerIdEnd);
        // $isMT = $this->faker->boolean
        $partner = 3615;

        $createdAt = $this->faker->dateTimeBetween($lastMonth, $thisMonth);
        $deliveredAt = clone $createdAt;
        $deliveredAt->modify("+{$this->faker->numberBetween(5, 10)} seconds");

        $isSent = $faker->boolean;
        $isDelivered = $isSent <> 0 ? $faker->boolean : 0;
        $error = $isDelivered <> 1 && $isSent <> 0 ? 1 : 0;

        return [
            'vendor_id' => 1,
            'telco' => $this->faker->randomElement($telcoOptions),
            'partner_id' => $partner,
            'mo_subscription_id' => $this->faker->randomElement([1, 2, 3]),
            'phone_number' => $this->generatePhoneNumber(),
            'error' => $error,
            'text' => $this->faker->realText(100),
            'delivered_at' => $deliveredAt,
            'is_delivered' => $isDelivered,
            'is_sent' => $isSent,
            'created_at' => $createdAt,
        ];
    }
}
