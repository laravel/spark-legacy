<?php

namespace Laravel\Spark\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Laravel\Spark\Console\Installation;
use Laravel\Spark\Contracts\Repositories\PerformanceIndicatorsRepository;

class StorePerformanceIndicatorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:kpi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store the performance indicators for the application';

    /**
     * Execute the console command.
     *
     * @param  PerformanceIndicatorsRepository  $indicators
     * @return mixed
     */
    public function handle(PerformanceIndicatorsRepository $indicators)
    {
        DB::table('performance_indicators')->insert([
            'monthly_recurring_revenue' => $indicators->monthlyRecurringRevenue(),
            'yearly_recurring_revenue' => $indicators->yearlyRecurringRevenue(),
            'daily_volume' => DB::table('invoices')->whereDate('created_at', '=', Carbon::today())->sum('total'),
            'new_users' => DB::table('users')->whereDate('created_at', '=', Carbon::today())->count(),
            'created_at' => Carbon::today(),
            'updated_at' => Carbon::today(),
        ]);

        $this->info('Performance indicators stored!');
    }
}
