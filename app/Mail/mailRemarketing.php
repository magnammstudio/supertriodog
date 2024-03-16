<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mailRemarketing extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($client)
    {
        $this->client = $client;

        $rmktClient=$this->client->rmkt->last();
        
        $date = Carbon::create(env('RMKT_FINALDATE'));
        if($date->isCurrentDay()){
            $status= "10 วันสุดท้าย ใกล้หมดเวลาอย่าลืมไปใช้สิทธิ์ โปรแกรม LOVE Solution Cat Plus ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้ ";
        }elseif($rmktClient){
            $rmktClientActive=$this->client->rmkt->where('active_status','activated')->last();
            if($rmktClient==$rmktClientActive){
                $status="ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง";
            }else{
                $lastSelect=$this->client->option_1??$this->client->option_2??$this->client->option_3;
                $thisSelect=$lastSelect==1?3:1;
                $status="คุณยังมีสิทธิ ".$thisSelect." เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม ".env('APP_NAME')." ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้";
                $status="ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง";
            }
        }else{
            if($this->client->option_2 && $this->client->option_3){
                $status="ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง";
                
            }else{
                $lastSelect=$this->client->option_1??$this->client->option_2??$this->client->option_3;
                $thisSelect=$lastSelect==1?3:1;
                $status="คุณยังมีสิทธิ ".$thisSelect." เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม ".env('APP_NAME')." ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้";

                // dd('send remider in 7 day last select '.$lastSelect);
            }
        }

        $this->status=$status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Remarketing',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.remarketing',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
