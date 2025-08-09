<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細に必要な情報が表示される()
    {
        // ユーザー作成（コメント投稿者）
        $user = User::factory()->create(['name' => 'コメントユーザー']);

        // 商品状態
        $condition = Condition::factory()->create(['name' => '新品']);

        // 商品作成
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト商品の説明です。',
            'condition_id' => $condition->id,
            'img_url' => 'https://example.com/image.jpg',
        ]);

        // カテゴリを複数作成し、商品に紐付け
        $category1 = Category::factory()->create(['name' => 'カテゴリ1']);
        $category2 = Category::factory()->create(['name' => 'カテゴリ2']);
        $item->categories()->attach([$category1->id, $category2->id]);

        // いいねを作成
        Like::factory()->count(3)->create(['item_id' => $item->id]);

        // コメントを作成
        Comment::factory()->count(2)->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'コメント内容',
        ]);

        // 商品詳細ページにアクセス
        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);

        // 商品の基本情報の表示確認
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('5000');
        $response->assertSee('テスト商品の説明です。');

        // 画像URLの確認（imgタグ内にURLが含まれているか）
        $response->assertSee('https://example.com/image.jpg');

        // 商品状態の表示確認
        $response->assertSee('新品');

        // カテゴリ名の表示確認（複数カテゴリ）
        $response->assertSee('カテゴリ1');
        $response->assertSee('カテゴリ2');

        // いいね数の表示（3件）
        $response->assertSee('3');

        // コメント数の表示（2件）
        $response->assertSee('2');

        // コメント内容とユーザー名の表示確認
        $response->assertSee('コメント内容');
        $response->assertSee('コメントユーザー');
    }
}
