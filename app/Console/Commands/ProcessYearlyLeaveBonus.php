<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class ProcessYearlyLeaveBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:process-yearly-bonus {--date= : Evaluation date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if employees have taken 0 leaves in the last 12 months and awards a bonus.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $evalDate = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::now();
        $this->info("Evaluating yearly leave bonuses as of: " . $evalDate->toDateString());

        // For this policy: "if 12 month no leave avail 12 day salary + fuel"
        // This script can be run monthly to check everyone's trailing 12 months,
        // or on their specific 12 month anniversary. Here we check trailing 12 months.
        
        $twelveMonthsAgo = $evalDate->copy()->subMonths(12);

        // Get all active users (assuming we only check active employees)
        $users = User::where('status', '!=', 'fired')->get();

        foreach ($users as $user) {
            // Check if they have been employed for at least 12 months
            // Assuming created_at is hire date for this specific case context
            if ($user->created_at > $twelveMonthsAgo) {
                continue; // Not here for 12 months yet
            }

            // Check how many approved leaves they had in the last 12 months
            $leaveCount = LeaveRequest::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('start_date', '>=', $twelveMonthsAgo)
                ->where('start_date', '<=', $evalDate)
                ->count();

            if ($leaveCount == 0) {
                // Award Bonus
                // Exact implementation depends on payroll logic...
                // e.g. $user->addBonus(12 days salary + fuel);
                
                $this->info("AWARD: User {$user->name} has 0 leaves in the last 12 months! Rewarding 12 days salary + fuel.");
                
                // Usually we would log this in a `BonusRecords` table so we don't reward them again tomorrow
                // For demonstration, we just log it in console. Ensure to track this state in production!
            }
        }
    }
}
