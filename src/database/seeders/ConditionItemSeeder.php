<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Condition;

class ConditionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = Item::find(1);
        $item1->conditions()->attach([1]);

        $item2 = Item::find(2);
        $item2->conditions()->attach([2]);

        $item3 = Item::find(3);
        $item3->conditions()->attach([3]);

        $item4 = Item::find(4);
        $item4->conditions()->attach([4]);

        $item5 = Item::find(5);
        $item5->conditions()->attach([1]);

        $item6 = Item::find(6);
        $item6->conditions()->attach([2]);

        $item7 = Item::find(7);
        $item7->conditions()->attach([3]);

        $item8 = Item::find(8);
        $item8->conditions()->attach([4]);

        $item9 = Item::find(9);
        $item9->conditions()->attach([1]);

        $item10 = Item::find(10);
        $item10->conditions()->attach([2]);

    }
}
