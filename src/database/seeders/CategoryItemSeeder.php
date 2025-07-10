<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;


class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bindings = [
            1 => [12],
            2 => [2],
            3 => [10],
            4 => [5],
            5 => [2],
            6 => [2, 13],
            7 => [4],
            8 => [10],
            9 => [10, 11],
            10 => [6],
        ];

        foreach ($bindings as $itemId => $categoryIds) {
            $item = Item::find($itemId);
            if ($item) {
                $item->categories()->attach($categoryIds);
            }
        }
    }
}
