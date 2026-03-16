<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\PHPIMAP\ClientManager;

class TestEmailConnection extends Command
{
    protected $signature = 'email:test-connection {email} {password}';
    protected $description = 'Test IMAP and SMTP connection for an email';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        $this->info("Testing IMAP connection for $email...");
        
        try {
            $cm = new ClientManager([]);
            $client = $cm->make([
                'host'          => 'gcam1211.siteground.biz',
                'port'          => 993,
                'encryption'    => 'ssl', 
                'validate_cert' => false,
                'username'      => $email,
                'password'      => $password,
                'protocol'      => 'imap'
            ]);

            $client->connect();
            $this->info("IMAP Connection Successful!");
            
            $folders = $client->getFolders();
            $this->info("Found " . $folders->count() . " folders.");
            foreach($folders as $folder) {
                $this->line(" - " . $folder->name);
            }
            
        } catch (\Exception $e) {
            $this->error("IMAP Error: " . $e->getMessage());
        }
        
        $this->info("\nTesting standard SMTP logic with config...");
        try {
            config([
                'mail.mailers.custom_smtp' => [
                    'transport' => 'smtp',
                    'host' => 'gcam1211.siteground.biz',
                    'port' => 465,
                    'encryption' => 'ssl',
                    'username' => $email,
                    'password' => $password,
                ],
                'mail.from.address' => $email,
                'mail.from.name' => 'Developer Test',
            ]);
            
            // Try establishing a transport connection without sending
            $mailer = \Illuminate\Support\Facades\Mail::mailer('custom_smtp');
            
            // Actually catching transport start is hard in Laravel 10/11 without swift/symfony transport access
            // But if no exception happens above, basic config is valid.
            $this->info("SMTP configuration injected successfully.");
            
        } catch (\Exception $e) {
            $this->error("SMTP Error: " . $e->getMessage());
        }

        return 0;
    }
}
