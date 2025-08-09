<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        // 商品を3件作成
        $products = Item::factory()->count(3)->create();

        $response = $this->get('/');

        // ステータスコード確認
        $response->assertStatus(200);

        // 商品名が全て表示されていることを確認
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function 購入済み商品は_sold_と表示される()
    {
        // 購入済みの商品
        $soldProduct = Item::factory()->create(['is_sold' => true]);

        // 未購入の商品
        $availableProduct = Item::factory()->create(['is_sold' => false]);

        $response = $this->get('/');

        // 購入済み商品には「Sold」が表示される
        $response->assertSee('Sold');

        // 未購入の商品名が表示されていること
        $response->assertSee($availableProduct->name);
        $response->assertDontSeeTextInOrder(['Sold', $availableProduct->name]); // 順序で検証するなら
    }

    /** @test */
    public function 自分が出品した商品は一覧に表示されない()
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // 自分が出品した商品
        $myProduct = Item::factory()->create(['user_id' => $user->id]);

        // 他ユーザーが出品した商品
        $otherProduct = Item::factory()->create();

        // 自分としてログイン
        $this->actingAs($user);

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        $response->assertStatus(200);

        // 自分の商品は表示されない
        $response->assertDontSee($myProduct->name);

        // 他ユーザーの商品は表示される
        $response->assertSee($otherProduct->name);
    }
}
