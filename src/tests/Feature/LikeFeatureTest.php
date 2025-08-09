<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザーは商品にいいねできる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/like/{$item->id}");

        $response->assertStatus(200); // APIが成功したか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 合計いいね数が1であること
        $this->assertEquals(1, $item->likes()->count());
    }

    /** @test */
    public function 既にいいねした商品はいいね解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 事前にいいねしておく
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete("/like/{$item->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals(0, $item->likes()->count());
    }

    /** @test */
    public function 未ログインユーザーはいいねできない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/like/{$item->id}");

        $response->assertRedirect('/login'); // 認証されていないとリダイレクトされる
        $this->assertDatabaseMissing('likes', [
            'item_id' => $item->id,
        ]);
    }
}
