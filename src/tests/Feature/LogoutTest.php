<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 認証済みユーザーはログアウトできる()
    {
        // ユーザー作成 & ログイン状態にする
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');

        // 認証状態が解除されていることを確認
        $this->assertGuest();
    }
}
