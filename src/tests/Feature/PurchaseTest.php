<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入ボタンを押下すると購入が完了する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'buyer_id' => null,
            'seller_id' => User::factory()->create()->id,
        ]);

        $response = $this->actingAs($user)->post(route('items.purchase', $item->id), [
            'payment' => 'カード支払い',
        ]);

        $response->assertRedirect(); // リダイレクト確認

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'buyer_id' => $user->id,
        ]);
    }

    /** @test */
    public function 購入済みの商品は商品一覧にてsoldと表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'buyer_id' => $user->id,
        ]);

        $response = $this->get('/products'); // 商品一覧ルート

        $response->assertSee('SOLD');
    }

    /** @test */
    public function 購入した商品は購入商品一覧に表示される()
    {
        $user = User::factory()->create();

        $purchasedItem = Item::factory()->create([
            'buyer_id' => $user->id,
        ]);

        $otherItem = Item::factory()->create([
            'buyer_id' => null,
        ]);

        $response = $this->actingAs($user)->get('/profile/purchases'); // 例: 購入商品一覧ページ

        $response->assertSee($purchasedItem->name);
        $response->assertDontSee($otherItem->name);
    }
}
