<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品出品画面から商品情報を保存できる()
    {
        // 出品ユーザー作成
        $user = User::factory()->create();

        // カテゴリを2つ作成
        $categories = Category::factory()->count(2)->create();

        // フォーム入力データを準備
        $formData = [
            'name' => 'テスト商品',
            'description' => 'テスト用の説明文です。',
            'price' => 5000,
            'condition_id' => 1,
            'categories' => $categories->pluck('id')->toArray(),
        ];

        // ログインしてPOST送信
        $response = $this->actingAs($user)->post('/items', $formData);

        // 保存されたことをDBで確認
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'テスト用の説明文です。',
            'price' => 5000,
            'condition_id' => 1,
            'seller_id' => $user->id,
        ]);

        // 中間テーブルも確認
        $item = Item::where('name', 'テスト商品')->first();
        $this->assertCount(2, $item->categories);

        // リダイレクト確認
        $response->assertRedirect(); // 保存後の遷移先がある場合は指定可能
    }
}
