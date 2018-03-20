<?php

namespace Tests\Feature;

use App\Models\Invoices;
use App\Models\Masterwallet;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateInvoice()
    {
        $this->seed('CryptocurrenciesTableSeeder');

        $masterwallet = factory(Masterwallet::class)->create();
        $user = User::find($masterwallet->user_id)->first();
        Auth::login($user);

        $response = $this->post('/invoices', [
            'order_id' => 4,
            'user_id' => $masterwallet->user_id,
            'store_id' => $masterwallet->store_id,
            'masterwallet_id' => $masterwallet->id,
            'price' => 20,
            'currency' => 'USD',
            'description' => 'Hardware wallets',
            'buyer_email' => 'test@gmail.com',
            'notification_url' => 'https://notifyexample.com/ipn'
        ]);

        $response->assertStatus(302);
        $invoice = Invoices::take(1)->first();

        self::assertEquals($invoice->store_id, 1);
        self::assertEquals($invoice->masterwallet_id, null);
        self::assertEquals($invoice->cryptocurrency_id, null);
        self::assertEquals($invoice->price, 20);
        self::assertEquals($invoice->currency, 'USD');
        self::assertEquals($invoice->description, 'Hardware wallets');
        self::assertEquals($invoice->buyer_email, 'test@gmail.com');
        self::assertEquals($invoice->notification_url, 'https://notifyexample.com/ipn');
    }
}
