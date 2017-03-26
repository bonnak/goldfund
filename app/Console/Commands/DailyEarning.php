<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Deposit;
use App\Earning;

class DailyEarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earning:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer receive daily earning.';

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

        Deposit::where('issue_date', '<', Carbon::now())
            ->where('expire_date', '>', Carbon::now())
            ->where('status', 1)
            ->chunk(200, function ($deposits){

            foreach ($deposits as $deposit) {

                if($deposit->daily_earning->where('created_at', '>=', Carbon::today())->count() > 0) continue;

                $earning = Earning::create([
                    'cust_id'       => $deposit->owner->id,
                    'plan_id'       => $deposit->plan->id,
                    'deposit_id'    => $deposit->id,
                    'amount'        => $deposit->amount * $deposit->plan->daily, 
                    'status'        => 1,
                ]);

                $this->line(
                    '# ' . $earning->owner->username . ' receive daily earning $' . $earning->amount .
                    ' (deposit_id = ' . $earning->deposit_id . ' and plan_name = ' . $earning->plan->name . ').'
                );
            }
        });

    }
}
