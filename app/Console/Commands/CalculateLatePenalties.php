<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Attendance;
use App\Models\LateRecord;
use App\Mail\LateWarningMail;
use App\Mail\SalaryDeductionMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CalculateLatePenalties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:process-penalties {--date= : The date to process (YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates late penalties for employee clock-ins and sends warning/deduction emails.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::yesterday();
        $this->info("Processing late penalties for: " . $targetDate->toDateString());

        $lateCutoffTime = Carbon::parse($targetDate->toDateString() . ' 16:55:00'); // 4:55 PM cutoff
        
        // 1. Find all users who clocked in yesterday after 04:55
        // Or didn\'t clock in (for a more advanced system, but rule only mentions "clocking in late")
        $attendances = Attendance::whereDate('clock_in_time', $targetDate->toDateString())
            ->where('clock_in_time', '>', $lateCutoffTime)
            ->get();

        foreach ($attendances as $attendance) {
            $user = $attendance->user;
            
            // Record this late
            $lateRecord = LateRecord::firstOrCreate([
                'user_id' => $user->id,
                'attendance_id' => $attendance->id,
            ], [
                'date' => $targetDate->toDateString(),
                'month' => $targetDate->month,
                'year' => $targetDate->year,
            ]);

            if (!$lateRecord->wasRecentlyCreated) {
                // Already processed this attendance record
                continue;
            }

            // Count lates this month
            $latesThisMonth = LateRecord::where('user_id', $user->id)
                ->where('month', $targetDate->month)
                ->where('year', $targetDate->year)
                ->count();

            $this->info("User {$user->name} was late. Total lates this month: {$latesThisMonth}");

            if ($latesThisMonth == 2) {
                // Send Warning Email
                Mail::to($user)->send(new LateWarningMail($user, $targetDate));
                $lateRecord->update(['warning_email_sent' => true]);
                $this->info("Sent warning email to {$user->email}");
            } elseif ($latesThisMonth == 3) {
                // Send Deduction Email & Deduct Salary
                Mail::to($user)->send(new SalaryDeductionMail($user, $targetDate));
                $lateRecord->update(['deduction_email_sent' => true]);
                
                // Actual deduction mechanism depends on payroll architecture, 
                // but conceptually:
                // $user->salary_deductions = $user->salary_deductions + ($user->total_package / 30);
                // $user->save();
                
                $this->info("Sent deduction email to {$user->email}");
                
                // Check for Habitual Late: Last month ALSO had 3+ lates
                $lastMonth = $targetDate->copy()->subMonth();
                $latesLastMonth = LateRecord::where('user_id', $user->id)
                    ->where('month', $lastMonth->month)
                    ->where('year', $lastMonth->year)
                    ->count();
                    
                if ($latesLastMonth >= 3) {
                    $this->warn("User {$user->name} is HABITUALLY LATE (3 lates last month & 3 lates this month). Bonus lost!");
                    // Handle bonus loss logic here
                }
            }
        }
    }
}
