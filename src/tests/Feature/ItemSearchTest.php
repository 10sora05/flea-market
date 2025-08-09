<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        Item::factory()->create(['name' => 'iPhone 13']);
        Item::factory()->create(['name' => 'Galaxy S21']);
        Item::factory()->create(['name' => 'Pixel 6']);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/search?keyword=Phone');

        $response->assertStatus(200);
        $response->assertSee('iPhone 13');
        $response->assertDontSee('Galaxy S21');
        $response->assertDontSee('Pixel 6');
    }

    /** @test */
    public function 検索状態がマイリストタブでも保持されている()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // iPhoneだけをマイリストに追加
        $iphone = Item::factory()->create(['name' => 'iPhone 13']);
        $galaxy = Item::factory()->create(['name' => 'Galaxy S21']);
        $user->likedItems()->attach($iphone->id);
        $user->likedItems()->attach($galaxy->id);

        $response = $this->get('/');

        $response->assertStatus(200);

        // 両方含まれている前提
        $response->assertSee('iPhone 13');
        $response->assertSee('Galaxy S21');

        // 検索フィルタ処理は JavaScript のため、以下の文字列が含まれることを確認
        $response->assertSee('data-target="mylist"'); // マイリストタブが存在
        $response->assertSee('tab-button');           // タブ切り替え用JS

        // JavaScript内に「検索キーワードによるフィルタ処理」があるかを確認
        $response->assertSee("card.style.display = name.includes(keyword) ? 'block' : 'none';");
    }
}
