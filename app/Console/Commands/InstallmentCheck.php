<?php

namespace App\Console\Commands;

use App\Models\Installment;
use Illuminate\Console\Command;

class InstallmentCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:installment-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $date = date('Y-m-d');

        $installments = Installment::where('date', $date)->get();

        foreach ($installments as $installment) {
            if ($installment->debt > 0) {
                $installment->status = 'debt';
                $installment->save();
            } else {
                $installment->status = 'paid';
                $installment->save();
            }
        }

    }
}
