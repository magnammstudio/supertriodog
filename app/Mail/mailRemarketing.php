<?php

namespace App\Mail;

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
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($client)
    {
        $this->client = $client;

        $rmktClient=$this->client->rmkt->last();
        
        if($rmktClient){
            $rmktClientActive=$this->client->rmkt->where('active_status','activated')->last();
            if($rmktClient==$rmktClientActive){
                $status="ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง";
            }else{
                // last select
                $lastSelect=$this->client->option_1??$this->client->option_2??$this->client->option_3;

                $thisSelect=$lastSelect==1?3:1;
                // swop
                $status="คุณยังมีสิทธิ ".$thisSelect." เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม LOVE Solution Cat Plus ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้";
            }
        }else{
            if($this->client->option_2 && $this->client->option_3){
                $status="ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง";
                // $dateSend = $this->client->updated_at->addDay(25);
                // dd('send remider in 25 day at '.$dateSend->toDateString());
                // status can select
            }else{
                // $dateSend = $this->client->updated_at->addDay(25);
                $lastSelect=$this->client->option_1??$this->client->option_2??$this->client->option_3;
                
                $thisSelect=$lastSelect==1?3:1;
                // last select
                // swop
                $status="คุณยังมีสิทธิ ".$thisSelect." เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม LOVE Solution Cat Plus ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้";

                // dd('send remider in 7 day last select '.$lastSelect);
            }
        }

        // $rmktClient=$this->client->rmkt->last();
        // 'ครบ 1 เดือนแล้ว ถึงเวลาที่คุณต้องปกป้อง พาราไซท์  อย่าลืมปกป้อง'
        // 'คุณยังมีสิทธิ 3 เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม LOVE Solution Cat Plus ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้'
        // 'คุณยังมีสิทธิ 1 เดือน อย่าลืมไปใช้สิทธิ์ โปรแกรม LOVE Solution Cat Plus ที่คลินิกหรือโรงพยาบาลสัตว์ ที่ได้ลงทะเบียนไว้'
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
