<?php

namespace App\Console\Commands;

use App\Mail\WeeklyVisitorReport;
use App\Models\VisitorLog;
use App\Services\VisitorTrackingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeeklyVisitorReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitors:weekly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly visitor statistics report to admin emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating weekly visitor report...');

        try {
            $trackingService = new VisitorTrackingService();
            
            // Get stats for last week
            $startDate = now()->subWeek()->startOfWeek();
            $endDate = now()->subWeek()->endOfWeek();
            
            $stats = $trackingService->getWeeklyStats($startDate, $endDate);
            
            // Get verified visitors for detailed list
            $visitors = VisitorLog::whereBetween('verified_at', [$startDate, $endDate])
                ->where('verified', true)
                ->get();

            // Get admin emails
            $adminEmails = config('mail.admin_emails', ['purchases@fieldengineerpro.com', 'patrick@nmtechnology.us']);
            
            $this->info("Sending report to " . count($adminEmails) . " recipients...");
            
            // Send email to each admin
            foreach ($adminEmails as $email) {
                Mail::to(trim($email))->send(new WeeklyVisitorReport($stats, $visitors));
                $this->info("✓ Sent to: " . $email);
            }

            $this->info('Weekly visitor report sent successfully!');
            $this->line('');
            $this->line("Report Summary:");
            $this->line("Period: {$stats['period_start']} to {$stats['period_end']}");
            $this->line("Total Visitors: {$stats['total_visitors']}");
            $this->line("Verified Visitors: {$stats['verified_visitors']}");
            $this->line("Verification Rate: {$stats['verification_rate']}%");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to send weekly report: ' . $e->getMessage());
            \Log::error('Weekly visitor report failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
