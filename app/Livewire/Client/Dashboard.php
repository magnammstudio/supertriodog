<?php

namespace App\Livewire\Client;

use App\Models\client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Dashboard extends Component
{
    public client $client;
    public $currentStep=1,$status=0;

    public $request;
    public $error;
    
    public function mount($phone=null){
        // dd($phone);
        // $this->client=client::with('vet')->where('phone',$phone)->first();
        $client=client::where('phone',$phone)->first();
        //    dd($client==null) ;
        if($client==null){
            return redirect(route('client.login'));
        }
        
        $this->client = $client;

        $this->request=[
            'vet_id'=>null,
            'offer'=>null,
            'offer_1'=>null,
            'offer_2'=>null,
            'offer_3'=>null,
            'offer_month'=>null,
        ];

        if(!env('SMS_API')){
            $this->request=[
                'vet_id'=>$this->client->vet_id,
                'offer'=>null,
                'offer_1'=>null,
                'offer_2'=>null,
                'offer_3'=>null,
                'offer_month'=>null,
            ];
        }

        if($this->client->active_status=='activated' 
        && $this->client->active_date!=null){
            $this->currentStep=6;
        }
    }
    public function render()
    {   
        if($this->client->vet->stockRemaining()<=0){
            // dd($this->client->vet->stockRemaining());
            $this->addError('stock', 'This Vet is out of stock');
        }
        return view('livewire.client.dashboard',[
            // 'stockRemain'=>10
        ]);
    }

    public function updated($propertyName)
    {
        $this->resetErrorBag();
        // dd($propertyName,$this->getErrorBag());
    }
    public function verifyVet(){
        // validate
        $this->request['offer_1']=$this->request['offer_1']??null;
        $this->request['offer_2']=$this->request['offer_2']??null;
        $this->request['offer_3']=$this->request['offer_3']??null;
        // $this->request['offer_month']=$this->request['offer_3']?3:null;
        // $this->request['offer_month']=$this->request['offer_3']?$this->request['offer_month']:null;
        // dd($this->request['offer_2']==null && $this->request['offer_3']==null);
        $validatedData = $this->validate([
            'request.vet_id'=>['required'],
            'request.offer_1'=>[Rule::requiredIf(function(){return $this->request['offer_2']==null && $this->request['offer_3']==null;})],
            'request.offer_2'=>[Rule::requiredIf(function(){return $this->request['offer_1']==null && $this->request['offer_3']==null;})],
            'request.offer_3'=>[Rule::requiredIf(function(){return $this->request['offer_1']==null && $this->request['offer_2']==null;})],
            'request.offer_month'=>['required_unless:request.offer_3,null'],
        ],[
            'request.*'=>'จำเป็นต้องระบุ',
            'request.offer_month.*'=>'กรุณาระบุจำนวนเดือน',
        ]);
        if($this->client->vet_id == $this->request['vet_id']){
            $this->client->option_1=$this->request['offer_1']??null;
            $this->client->option_2=$this->request['offer_2']??null;
            $this->client->option_3=$this->request['offer_month']??null;

            $this->client->active_status = 'activated';
            $this->client->active_date = now();
            $this->client->save();
            // dd($this->client);
            $this->step(6);
        }else{
            $this->status=-1;
            // $this->error="error";
            $this->addError('request.vet_id', 'รหัสคลินิก หรือ โรงพยาบาลสัตว์ ไม่ถูกต้อง');
        }
    }
    public function step($goto=null){
        $this->currentStep =$goto??$this->currentStep+1;
    }
}
