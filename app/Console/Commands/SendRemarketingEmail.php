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
    protected $description = 'send re marketing email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //update last 30 day
        $clients = client::whereDate('updated_at','<=',today()->subDay(30))->get();
        if ($clients->count() > 0) {
            foreach ($clients as $client) {
                Mail::to($client->email)->send(new mailRemarketing($client));
                //send sms
                //update 
                
                $remark = array(
                    'send data'=>$client->remark['send data']??now(),
                    'number of send'=>($client->remark['send data']+1)??1
                );
                // dd();
                $client->updated_at=today();
                $client->save();
            }
        }
    
        return $clients;
    }
}
