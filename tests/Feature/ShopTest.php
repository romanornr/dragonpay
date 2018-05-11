<?php

namespace Tests\Feature;

use App\Models\Shop;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can login, go to the create shops page
     * and create a store
     */
    public function testCreateStoreAsLoggedInUser()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $response = $this->get('/shops/create');
        $response->assertStatus(200);

        $response = $this->post('/shops', [
            'name' => 'store1',
            'website' => 'https://store1example.com',
            'expiration_time' => 15,
            'user_id' => $user->id
        ]);

        $response->assertStatus(302);

        $shop = Shop::find(1);
        self::assertNotEquals($shop->name, 'storeee1');
        self::assertEquals($shop->name, 'store1');
        self::assertEquals($shop->website, 'https://store1example.com');
        self::assertEquals($shop->expiration_time, 15);
        self::assertEquals($shop->user_id, $user->id);

    }

}
