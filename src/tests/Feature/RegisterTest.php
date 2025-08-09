<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test 名前が未入力だとバリデーションエラーになる */
    public function 名前が未入力だとバリデーションエラーになる()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください。',
        ]);
    }

    /** @test メールアドレスが未入力だとバリデーションエラーになる */
    public function メールアドレスが未入力だとバリデーションエラーになる()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください。',
        ]);
    }

    /** @test パスワードが未入力だとバリデーションエラーになる */
    public function パスワードが未入力だとバリデーションエラーになる()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください。',
        ]);
    }

    /** @test パスワード確認と一致しないとバリデーションエラーになる */
    public function パスワード確認と一致しないとバリデーションエラーになる()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors([
            'password' => '確認用パスワードが一致しません。',
        ]);
    }
}
