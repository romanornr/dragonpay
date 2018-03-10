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

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

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
        if($DragonPay->isPaid($symbol, $this->invoice->payment_address, $this->invoice->cryptoDue)){
            $this->invoice->cryptoDue = 0;
            $this->invoice->status = 'confirmed';
            $this->invoice->save();
        }else{
            $this->invoice->status = 'failed';
            $this->invoice->save();
        }
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(5);
    }

//    /**
//     * The job failed to process.
//     *
//     * @param  Exception  $exception
//     * @return void
//     */
//    public function failed(Exception $exception)
//    {
//        // Send user notification of failure, etc...
//    }
}
