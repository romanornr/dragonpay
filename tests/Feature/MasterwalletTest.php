<?php

namespace Tests\Feature;

use App\Models\Cryptocurrency;
use App\Models\Masterwallet;
use App\Models\Store;
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
        $this->store = factory(Store::class)->create();
        $this->user = User::find($this->store->user_id)->first();

    }

    public function test_a_user_can_see_his_masterwallets() //Needs fix
    {
        $masterwallet = factory(Masterwallet::class)->create();
        $user = User::find($masterwallet->user_id)->first();
        Auth::login($user);
        $this->assertAuthenticated($guard = null);

        $response = $this->get('/masterwallets');

        $response->assertSee('cryptocurrency');
        $response->assertSee('legacy');
       // $response->assertSee('xpub6DBfFoZHK5ZCzuoViVTzmRTf91DEVvYoifJQToHhHAwS2pmyeQCfQ5pqCg65WYBB2jnyDtoPRdpLVgwH5UpFswFX1qNtD4ccpZJXB9fqkQA');
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
        ]);

        $response->assertStatus(302);

        $masterwallet = Masterwallet::find(1);
        self::assertEquals($masterwallet->store_id, $this->store->id);
        self::assertEquals($masterwallet->cryptocurrency_id, 1);
        self::assertEquals($masterwallet->address_type, 'segwit');
        self::assertEquals($masterwallet->script_type, 'p2sh');
        self::assertEquals($masterwallet->user_id, $this->store->user_id);
        
    }

}