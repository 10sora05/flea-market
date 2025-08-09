<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 10000),
            'seller_id' => null, // 必要に応じて変更
            'is_sold' => false,
            'brand' => $this->faker->word(),
            'condition_id' => 1, // 仮のID、テストデータに合わせて変更
            'img_url' => null,
            'image_path' => null,
        ];
    }
}
