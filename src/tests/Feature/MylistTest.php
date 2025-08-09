<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        // いいねした商品
        $likedItem = Item::factory()->create();
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        // いいねしていない商品
        $notLikedItem = Item::factory()->create();

        $response = $this->actingAs($user)->get('/'); // indexルートを想定

        $response->assertStatus(200);
        $response->assertSee($likedItem->name);
        $response->assertDontSee($notLikedItem->name);
    }

    /** @test */
    public function 購入済み商品は_sold_と表示される()
    {
        $user = User::factory()->create();

        $soldItem = Item::factory()->create(['buyer_id' => User::factory()->create()->id]);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $soldItem->id,
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('SOLD');
        $response->assertSee($soldItem->name);
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();

        $myItem = Item::factory()->create(['seller_id' => $user->id]);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $myItem->id,
        ]);

        $otherItem = Item::factory()->create();
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $otherItem->id,
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee($myItem->name);
        $response->assertSee($otherItem->name);
    }

    /** @test */
    public function 未認証の場合はマイリストに何も表示されない()
    {
        $item = Item::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee($item->name);
    }
}
