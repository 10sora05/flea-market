<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 必要なユーザー情報が取得できる()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'test-profile.jpg',
        ]);

        // 出品した商品
        $listedItem = Item::factory()->create([
            'seller_id' => $user->id,
            'name' => '出品商品A',
        ]);

        // 購入した商品
        $purchasedItem = Item::factory()->create([
            'buyer_id' => $user->id,
            'name' => '購入商品B',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);

        // ユーザー名が表示されている
        $response->assertSee('テストユーザー');

        // プロフィール画像URLが含まれている
        $response->assertSee('test-profile.jpg');

        // 出品商品が表示されている
        $response->assertSee('出品商品A');

        // 購入商品が表示されている
        $response->assertSee('購入商品B');
    }
}
