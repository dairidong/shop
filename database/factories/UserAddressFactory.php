<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    protected static array $addresses = [
        ['北京市', '市辖区', '东城区'],
        ['河北省', '石家庄市', '长安区'],
        ['江苏省', '南京市', '浦口区'],
        ['江苏省', '苏州市', '相城区'],
        ['广东省', '深圳市', '福田区'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $address = fake()->randomElement(self::$addresses);

        return [
            'province' => $address[0],
            'city' => $address[1],
            'district' => $address[2],
            'address' => sprintf('第%d街道第%d号', fake()->randomNumber(2), $this->faker->randomNumber(3)),
            'user_id' => User::factory(),
            'zip' => fake()->postcode,
            'contact_name' => fake()->name,
            'contact_phone' => fake()->phoneNumber,
        ];
    }
}
