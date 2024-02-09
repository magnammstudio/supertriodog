<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email every 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Code to send the email using Laravel's Mail facade or any other mail library
        Mail::to('recipient@example.com')->send(new \App\Mail\ExampleEmail());

        $this->info('Email sent successfully.');
    }
}
