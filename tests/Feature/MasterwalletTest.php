<?php

namespace Tests\Feature;

use App\Models\Cryptocurrency;
use App\Models\Masterwallet;
use App\Models\Shop;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Seeder;

class MasterwalletTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->seed('CryptocurrenciesTableSeeder');
        $this->store = factory(Shop::class)->create();
        $this->user = User::find($this->store->user_id)->first();

    }

    public function test_a_user_can_see_his_masterwallets()
    {
        $masterwallet = factory(Masterwallet::class)->create();
        $user = User::find($masterwallet->user_id);
        Auth::login($user);
        $this->assertAuthenticated($guard = null);

        $response = $this->get('/masterwallets');

        $response->assertSee('cryptocurrency');
        $response->assertSee('Mining-Rigs');
        $response->assertSee('segwit');
        $response->assertSee($masterwallet->address_type, 'segwit');
    }

    public function testCreateMasterwallet()
    {
        Auth::login($this->user);
        $response = $this->get('/masterwallets/create');
        $response->assertStatus(200);

        $response = $this->post('/masterwallets', [
            'store_id' => $this->store->id,
            'cryptocurrency_id' => 1,
            'address_type' => 'segwit',
            'master_public_key' => 'xpub6DBfFoZHK5ZCzuoViVTzmRTf91DEVvYoifJQToHhHAwS2pmyeQCfQ5pqCg65WYBB2jnyDtoPRdpLVgwH5UpFswFX1qNtD4ccpZJXB9fqkQA',
            'min_confirmations' => 1,
        ]);

        $response->assertStatus(302);

        $masterwallet = Masterwallet::find(1);
        self::assertEquals($masterwallet->store_id, $this->store->id);
        self::assertEquals($masterwallet->cryptocurrency_id, 1);
        self::assertEquals($masterwallet->address_type, 'segwit');
        self::assertEquals($masterwallet->script_type, 'p2sh');
        self::assertEquals($masterwallet->user_id, $this->store->user_id);
        self::assertEquals($masterwallet->min_confirmations, 1);

        $response = $this->get('/masterwallets');

        $response->assertSee('cryptocurrency');
        $response->assertSee('segwit');
    }

    function test_unauthorized_user_may_not_delete_masterwallets()
    {
        $this->withExceptionHandling();
        $masterwallet = factory(Masterwallet::class)->create();
        $this->call('DELETE', "/masterwallets/{{ $masterwallet->id }}", ['_token' => csrf_token()])->assertRedirect('/login');

        Auth::login($this->user); //login with wrong user (user has no permission over the newly created $masterwallet
        $response = $this->call('DELETE', "/masterwallets/{{ $masterwallet->id }}", ['_token' => csrf_token()]);
        $response->assertStatus(404);
    }

    // Needs fix
    function test_authorized_user_has_permission_to_delete_masterwallets() //needs fix
    {
        $this->withExceptionHandling();
        $masterwallet = factory(Masterwallet::class)->create();
        $user = User::find($masterwallet->user_id);
        Auth::login($user);
        $this->assertAuthenticated($guard = null);

        $response = $this->call('DELETE', "/masterwallets/{{ $masterwallet->id }}", ['_token' => csrf_token()]);
        $response->assertRedirect(302);
    }

}