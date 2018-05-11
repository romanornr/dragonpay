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

        $store = Shop::find(1);
        self::assertNotEquals($store->name, 'storeee1');
        self::assertEquals($store->name, 'store1');
        self::assertEquals($store->website, 'https://store1example.com');
        self::assertEquals($store->expiration_time, 15);
        self::assertEquals($store->user_id, $user->id);

    }

}
