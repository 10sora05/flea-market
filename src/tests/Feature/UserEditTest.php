<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザー情報変更画面に初期値が表示されている()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'post' => '123-4567',
            'address' => '東京都渋谷区テスト1-2-3',
            'profile_image' => 'profile.jpg',
        ]);

        // 認証して編集ページへアクセス
        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200);

        // フォームに過去の値が入力されていることを検証
        $response->assertSee('テスト太郎');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区テスト1-2-3');
        $response->assertSee('profile.jpg');
    }
}
