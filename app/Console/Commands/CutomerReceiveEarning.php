<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\LevelEarningCommission;
use App\BinaryEarningCommission;

class CutomerReceiveEarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earning:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer receiving earning';

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

        $this->approveDailyEarning();
        $this->approveDirectEarning();
        $this->approveLevelEarning();
        $this->approveBinaryEarning();
    }


    protected function approveDailyEarning()
    {
        $earnings = Earning::with('owner', 'deposit', 'plan')
                            ->where('status', 0)
                            ->get();

        $earnings->each(function ($earning, $key) {
            $earning->status = 1;
            $earning->save();


            $this->line(
                '#' . $key . ' ' . 
                $earning->owner->username . ' receive daily earning $' . $earning->amount .
                ' (deposit_id = ' . $earning->deposit_id . ' and plan_name = ' . $earning->plan->name . ').'
            );
        });
    }

    protected function approveDirectEarning()
    {
        $earnings = SponsorEarningCommission::with('owner', 'deposit')
                            ->where('status', 0)
                            ->get();

        $earnings->each(function ($earning, $key) {
            $earning->status = 1;
            $earning->save();


            $this->line(
                '#' . $key . ' ' . 
                $earning->owner->username . ' receive direct earning $' . $earning->amount .
                ' from direct downline ' . $earning->deposit->owner->username . '.'
            );
        });
    }

    protected function approveLevelEarning()
    {
        $earnings = LevelEarningCommission::with('owner', 'deposit')
                            ->where('status', 0)
                            ->get();

        $earnings->each(function ($earning, $key) {
            $earning->status = 1;
            $earning->save();


            $this->line(
                '#' . $key . ' ' . 
                $earning->owner->username . ' receive level earning $' . $earning->amount .
                ' (level number = ' . $earning->level_number . ').'
            );
        });
    }

    protected function approveBinaryEarning()
    {
        $earnings = BinaryEarningCommission::with('sponsor')
                            ->where('status', 0)
                            ->get();

        $earnings->each(function ($earning, $key) {
            $earning->status = 1;
            $earning->save();


            $this->line(
                '#' . $key . ' ' . 
                $earning->sponsor->username . ' receive binary earning $' . $earning->amount .
                ' from pair ' . $earning->left_child->username . 
                ' and ' . $earning->right_child->username . '.'
            );
        });
    }
}
