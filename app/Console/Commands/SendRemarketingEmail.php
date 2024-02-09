<?php

namespace App\Console\Commands;

use App\Mail\mailConfirmation;
use App\Mail\mailRemarketing;
use App\Models\client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
// use Mail;

class SendRemarketingEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-remarketing-email';

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
        //update last 30 day
        $clients = client::whereDate('updated_at',now()->subDay(30))->get();
        if ($clients->count() > 0) {
            foreach ($clients as $client) {
                Mail::to($client)->send(new mailRemarketing($client));
                //send sms
                //update 
            }
        }
    
        return 0;
    }
}
