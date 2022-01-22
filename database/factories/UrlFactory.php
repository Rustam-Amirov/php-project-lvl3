<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Url;

class UrlFactory extends Factory
{
      protected $model = Url::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomDigitNotNull(),
            'name' => $this->faker->url(),
            'created_at' => $this->faker->unixTime(),
        ];
    }
}
