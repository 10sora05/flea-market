<?php

namespace Tests\Browser;

use Tests\TestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;

class ShippingAddressTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function 登録した住所が購入画面に表示される()
    {
        $user = User::factory()->create([
            'post' => '123-4567',
            'address' => '東京都新宿区テスト1-2-3',
            'bldg' => 'テストビル101',
        ]);

        $item = Item::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit(route('items.purchase.form', $item->id))
                ->assertSee('123-4567')
                ->assertSee('東京都新宿区テスト1-2-3')
                ->assertSee('テストビル101');
        });
    }
}
