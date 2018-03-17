<?php

namespace Tests\Unit;

use App\Models\Stores;
use Prophecy\Comparator\Factory;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can login, go to the create stores page
     * and create a store
     */
    public function testCreateStoreAsLoggedInUser()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(302);
        $response = $this->get('/stores/create');
        $response->assertStatus(200);

        $response2 = $this->post('/stores', [
            'name' => 'store1',
            'website' => 'https://store1example.com',
            'min_confirmations' => 1,
            'expiration_time' => 15,
            'user_id' => $user->id
        ]);

        $response2->assertStatus(302);

        $store = Stores::find(1);
        self::assertEquals($store->name, 'store1');
        self::assertEquals($store->website, 'https://store1example.com');
        self::assertEquals($store->min_confirmations, 1);
        self::assertEquals($store->expiration_time, 15);
        self::assertEquals($store->user_id, $user->id);

    }
}
