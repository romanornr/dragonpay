<?php

namespace App\Jobs;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DragonPay\DragonPay;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\DB;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 20;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 20;

    /**
     * Create a new job instance.
     * @param  Invoices $invoice
     * @return void
     */
    public function __construct(Invoices $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $DragonPay = new DragonPay();
        $symbol = $this->invoice->cryptocurrency->symbol;

        if($DragonPay->isPaid($symbol, $this->invoice->payment_address, $this->invoice->crypto_due)) {
            $this->invoice->crypto_paid = $this->invoice->crypto_due;
            $this->invoice->status = 'confirmed';
            $this->invoice->save();
            return;
        }

        throw new Exception('not paid yet');
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(10);
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->invoice->status = 'invalid';
        $this->invoice->save();
    }
}
