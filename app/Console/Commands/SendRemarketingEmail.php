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
        $clients = client::whereDate('updated_at','<=',now()->subDay(30))->get();
        $clients = client::whereDate('updated_at','<=',now()->sunDay(1))->get();
        if ($clients->count() > 0) {
            foreach ($clients as $client) {
                Mail::to($client)->send(new mailRemarketing($client));
                //send sms
                //update 
                $client->updated_at=today();
                $client->save();
            }
        }
    
        return 0;
    }
}
