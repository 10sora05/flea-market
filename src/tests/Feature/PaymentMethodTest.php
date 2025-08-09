<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PaymentMethodTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function コンビニ払いが初期表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['price' => 1500, 'is_sold' => false]);

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit(route('items.purchase.form', $item->id))
                ->assertSeeIn('#selected-payment', 'コンビニ払い');
        });
    }

    /** @test */
    public function 支払い方法を変更すると正しく反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['price' => 1500, 'is_sold' => false]);

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit(route('items.purchase.form', $item->id))
                ->select('#payment-method', 'カード支払い')
                ->waitForText('カード支払い', 2, '#selected-payment')
                ->assertSeeIn('#selected-payment', 'カード支払い');
        });
    }
}
