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
            'symbol' => 'btc'
        ]);

        DB::table('cryptocurrencies')->insert([
            'name'  => 'viacoin',
            'symbol' => 'via'
        ]);

        DB::table('cryptocurrencies')->insert([
            'name'  => 'litecoin',
            'symbol' => 'ltc'
        ]);
    }
}
