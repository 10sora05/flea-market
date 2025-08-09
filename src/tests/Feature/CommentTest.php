<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect(); // 成功後リダイレクトされる想定
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

    /** @test */
    public function ログインしていないユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/items/{$item->id}/comments", [
            'comment' => 'ログインしてないユーザーのコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'comment' => 'ログインしてないユーザーのコメント',
        ]);
    }

    /** @test */
    public function コメントが空の場合はバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    /** @test */
    public function コメントが255文字を超えるとバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
