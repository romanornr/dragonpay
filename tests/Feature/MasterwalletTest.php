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

    public function testCreateMasterwallet()
    {
        $this->seed('CryptocurrenciesTableSeeder');

        $store = factory(Store::class)->create();
        $user = User::find($store->user_id)->first();
        Auth::login($user);
        $response = $this->get('/masterwallets/create');
        $response->assertStatus(200);

        $response = $this->post('/masterwallets', [
            'store_id' => $store->id,
            'cryptocurrency_id' => 1,
            'address_type' => 'segwit',
            'master_public_key' => 'xpub6DBfFoZHK5ZCzuoViVTzmRTf91DEVvYoifJQToHhHAwS2pmyeQCfQ5pqCg65WYBB2jnyDtoPRdpLVgwH5UpFswFX1qNtD4ccpZJXB9fqkQA',
        ]);

        $response->assertStatus(302);

        $masterwallet = Masterwallet::find(1);
        self::assertEquals($masterwallet->store_id, $store->id);
        self::assertEquals($masterwallet->cryptocurrency_id, 1);
        self::assertEquals($masterwallet->address_type, 'segwit');
        self::assertEquals($masterwallet->script_type, 'p2sh');
        self::assertEquals($masterwallet->user_id, $store->user_id);
        
    }

}