<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptocurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cryptocurrencies')->insert([
           'name'  => 'bitcoin',
            'symbol' => 'btc',
            'segwit' => 1,
            'bech32' => 1
        ]);

        DB::table('cryptocurrencies')->insert([
            'name'  => 'viacoin',
            'symbol' => 'via',
            'segwit' => 1,
            'bech32' => 1
        ]);

        DB::table('cryptocurrencies')->insert([
            'name'  => 'litecoin',
            'symbol' => 'ltc',
            'segwit' => 1,
            'bech32' => 1
        ]);
    }
}
