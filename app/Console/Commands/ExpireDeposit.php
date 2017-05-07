<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Deposit;
use App\Earning;

class ExpireDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earning:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop customers deposit earning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('[' . Carbon::now()->toDateTimeString() . ']');

        Deposit::where('expire_date', '<=', Carbon::now())
            ->where('status', 1)
            ->chunk(200, function ($deposits){

            foreach ($deposits as $deposit) {

                $deposit->status = 4;
                $deposit->save();

                $this->line(
                    '# ' . $deposit->id . ' of '   . $deposit->owner->username . ' stop receiveing earning'
                );
            }
        });
    }
}
